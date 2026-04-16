<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;
use App\Models\JobType;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1)->with(['jobType', 'category']);

        // Keyword filter
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request) {
                $query->where('title', 'like', '%'.$request->keyword.'%')
                      ->orWhere('description', 'like', '%'.$request->keyword.'%');
            });
        }

        // Location filter
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', 'like', '%'.$request->location.'%');
        }

        // Category filter
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }

        // Job Type filter
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobTypeArray);
        }

        // Experience filter
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        // Sorting
        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs = $jobs->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs
        ]);
    }

    public function detail($id)
    {
        $job = Job::with(['jobType', 'category'])->findOrFail($id);

        return view('front.jobDetail', [
            'job' => $job
        ]);
    }

    public function applyJob(Request $request)
    {
        $id = $request->id;

        // Check if user is logged in
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'You need to login to apply for a job.'
            ]);
        }

        // Find the job
        $job = Job::find($id);

        if ($job == null) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found.'
            ]);
        }

        // Prevent employer from applying to their own job
        $userId = Auth::user()->id;

        if ($job->user_id == $userId) {
            return response()->json([
                'status' => false,
                'message' => 'You cannot apply to your own job.'
            ]);
        }

        // Check for duplicate application
        $alreadyApplied = JobApplication::where('user_id', $userId)
                                        ->where('job_id', $id)
                                        ->count();

        if ($alreadyApplied > 0) {
            return response()->json([
                'status' => false,
                'message' => 'You have already applied for this job.'
            ]);
        }

        // Save the application
        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = $userId;
        $application->employer_id = $job->user_id;
        $application->applied_date = now();
        $application->save();

        return response()->json([
            'status' => true,
            'message' => 'You have successfully applied for this job.'
        ]);
    }
}
