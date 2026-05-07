<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvSkill extends Model
{
    protected $table = 'cv_skills';

    protected $fillable = [
        'cv_id',
        'skill_id',
        'proficiency_level_id',
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function proficiencyLevel()
    {
        return $this->belongsTo(ProficiencyLevel::class);
    }
}