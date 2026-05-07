<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\City;
use App\Models\District;

class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    public function processRegistration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,employer',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'You have registered successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            }

            return redirect()->route('account.login')
                ->with('error', 'Either Email/Password is incorrect');
        }

        return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {
            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id . '-' . time() . '.' . $ext;
            $image->move(public_path('/profile_pic/'), $imageName);

            User::where('id', $id)->update(['image' => $imageName]);

            session()->flash('success', 'Profile picture updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function createJob()
{
    if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
        abort(403, 'Only employers can post jobs.');
    }

    $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
    $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
    $countries = Country::orderBy('name')->get();
    $cities = City::orderBy('name')->get();
    $districts = District::orderBy('name')->get();

    return view('front.account.job.create', [
        'categories' => $categories,
        'job_types' => $jobTypes,
        'countries' => $countries,
        'cities' => $cities,
        'districts' => $districts,
    ]);
}

    public function saveJob(Request $request)
    {
        if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers can post jobs.');
        }

        $rules = [
    'title' => 'required|min:5|max:200',
    'category' => 'required',
    'jobType' => 'required',
    'vacancy' => 'required|integer',

    'country_id' => 'required|exists:countries,id',
    'city_id' => 'required|exists:cities,id',
    'district_id' => 'nullable|exists:districts,id',
    'work_arrangement' => 'required|in:onsite,remote,hybrid',

    'salary_range' => 'required',
    'salary_type' => 'required|in:gross,net',

    'description' => 'required',
    'company_name' => 'required|min:3|max:75',
];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary_range = $request->salary_range;
$job->salary_type = $request->salary_type;

$job->country_id = $request->country_id;
$job->city_id = $request->city_id;
$job->district_id = $request->district_id;
$job->work_arrangement = $request->work_arrangement;

// Optional old columns for backward compatibility
$job->salary = $request->salary_range;
$job->location = trim(
    ($request->district_id ? optional(District::find($request->district_id))->name . ', ' : '') .
    optional(City::find($request->city_id))->name . ', ' .
    optional(Country::find($request->country_id))->name
);
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job added successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function myJobs()
    {
        if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers can view posted jobs.');
        }

        $jobs = Job::where('user_id', Auth::user()->id)
            ->with('jobType')
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return view('front.account.job.my-jobs', [
            'jobs' => $jobs
        ]);
    }

    public function editJob(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers can edit jobs.');
        }

        $categories = Category::orderBy('name', 'ASC')
            ->where('status', 1)
            ->get();

        $job_types = JobType::orderBy('name', 'ASC')
            ->where('status', 1)
            ->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('front.account.job.edit', [
            'categories' => $categories,
            'job_types' => $job_types,
            'job' => $job
        ]);
    }

    public function updateJob(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers can update jobs.');
        }

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:75',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $job = Job::where([
                'id' => $id,
                'user_id' => Auth::user()->id
            ])->first();

            if ($job == null) {
                abort(404);
            }

            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success', 'Job updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ]);
    }

    public function deleteJob(Request $request, $id)
    {
        if (!in_array(Auth::user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers can delete jobs.');
        }

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Either job deleted or not found.');

            return response()->json([
                'status' => false
            ]);
        }

        $job->delete();

        session()->flash('success', 'Job deleted successfully.');

        return response()->json([
            'status' => true
        ]);
    }

    public function myJobApplications()
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Only job seekers can view job applications.');
        }

        $jobApplications = JobApplication::where('user_id', Auth::user()->id)
            ->with(['job', 'job.jobType', 'job.applications'])
            ->paginate(10);

        return view('front.account.job.my-job-applications', [
            'jobApplications' => $jobApplications
        ]);
    }

    public function removeJobs(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Only job seekers can remove job applications.');
        }

        $jobApplication = JobApplication::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])->first();

        if ($jobApplication == null) {
            session()->flash('error', 'Job application not found');

            return response()->json([
                'status' => false
            ]);
        }

        $jobApplication->delete();

        session()->flash('success', 'Job application removed successfully.');

        return response()->json([
            'status' => true
        ]);
    }

    public function bookmarkJob(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Only job seekers can save jobs.');
        }

        $id = $request->id;

        $job = Job::where('id', $id)->first();

        if ($job == null) {
            session()->flash('error', 'Job not found.');
            return response()->json(['status' => false, 'message' => 'Job not found.']);
        }

        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
        ])->count();

        if ($count > 0) {
            session()->flash('error', 'You have already saved this job.');
            return response()->json(['status' => false, 'message' => 'You already saved this job.']);
        }

        $savedJob = new SavedJob();
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        session()->flash('success', 'Job saved successfully.');
        return response()->json(['status' => true, 'message' => 'Job saved successfully.']);
    }

    public function savedJobs()
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Only job seekers can view saved jobs.');
        }

        $savedJobs = SavedJob::where('user_id', Auth::user()->id)
            ->with('job')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('front.account.saved-jobs', [
            'savedJobs' => $savedJobs,
        ]);
    }

    public function removeSavedJob(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403, 'Only job seekers can remove saved jobs.');
        }

        $savedJob = SavedJob::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($savedJob == null) {
            session()->flash('error', 'Saved job not found.');
            return response()->json(['status' => false]);
        }

        $savedJob->delete();

        session()->flash('success', 'Saved job removed successfully.');
        return response()->json(['status' => true]);
    }

    public function changePassword()
    {
        return view('front.account.change-password');
    }

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->errors()]);
        }

        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return response()->json([
                'status' => false,
                'errors' => ['old_password' => ['The old password is incorrect.']]
            ]);
        }

        User::where('id', Auth::user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        session()->flash('success', 'Password updated successfully.');
        return response()->json(['status' => true, 'message' => 'Password updated successfully.']);
    }

    public function forgotPassword()
    {
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')
                ->withInput()
                ->withErrors($validator);
        }

        $token = Str::random(60);

        \DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();

        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $user = User::where('email', $request->email)->first();

        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'You have requested to change your password.',
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()
            ->route('account.forgotPassword')
            ->with('success', 'Please check your email to change your password.');
    }

    public function resetPassword($token)
    {
        $tokenData = \DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();

        if (!$tokenData) {
            return redirect()
                ->route('account.forgotPassword')
                ->with('error', 'Invalid token.');
        }

        return view('front.account.reset-password', ['token' => $tokenData]);
    }

    public function processResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('account.resetPassword', $request->token)
                ->withErrors($validator);
        }

        $tokenData = \DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first();

        if (!$tokenData) {
            return redirect()
                ->route('account.forgotPassword')
                ->with('error', 'Invalid token.');
        }

        User::where('email', $tokenData->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        \DB::table('password_reset_tokens')
            ->where('email', $tokenData->email)
            ->delete();

        return redirect()
            ->route('account.login')
            ->with('success', 'Password changed successfully. You can now login with your new password.');
    }
}