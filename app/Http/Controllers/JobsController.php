<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;

class JobsController extends Controller
{
    public function detail($id)
    {
        $job = Job::with(['jobType', 'category'])->findOrFail($id);

        return view('front.jobDetail', [
            'job' => $job
        ]);
    }
}
