<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvEducation extends Model
{
    protected $table = 'cv_educations';

    protected $fillable = [
        'cv_id',
        'institution_id',
        'degree_level_id',
        'major_id',
        'start_year',
        'end_year',
        'description',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function degreeLevel()
    {
        return $this->belongsTo(DegreeLevel::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }
}