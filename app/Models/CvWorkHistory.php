<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvWorkHistory extends Model
{
    protected $table = 'cv_work_histories';

    protected $fillable = [
        'cv_id',
        'company_name',
        'job_title',
        'job_type_id',
        'industry_id',
        'start_year',
        'end_year',
        'is_present',
        'job_description',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }
}