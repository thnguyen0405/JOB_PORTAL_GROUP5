<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Job;

class JobApplication extends Model
{
    use HasFactory;

    protected $table = 'job_application';

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }
}
