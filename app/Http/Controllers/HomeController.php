<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class HomeController extends Controller
{
    //
    public function index()
    {
        $latestJobs = Job::where('status', 1)
                        ->with('jobType')
                        ->orderBy('created_at', 'DESC')
                        ->take(6)
                        ->get();

        return view('front.home', [
            'latestJobs' => $latestJobs
        ]);
    }
        public function contact()
    {
        return view('front.contact');
    }
}
