<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\CvCategory;
use App\Models\Skill;
use App\Models\ProficiencyLevel;
use App\Models\Country;
use App\Models\City;
use App\Models\DegreeLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CvSearchController extends Controller
{
    public function index(Request $request)
    {
        // Employer Search & View Only
        if (!in_array(auth()->user()->role, ['employer', 'admin'])) {
            abort(403, 'Only employers or administrators can search and view CVs.');
        }

        $query = Cv::with([
            'user',
            'category',
            'country',
            'city',
            'district',
            'skills.skill',
            'skills.proficiencyLevel',
            'educations.degreeLevel',
            'educations.institution',
            'educations.major',
            'workHistories',
            'certificates',
        ]);

        // Approximate work experience length
        $query->select('cvs.*')->selectSub(function ($q) {
            $q->from('cv_work_histories')
                ->selectRaw("
                    COALESCE(
                        SUM(
                            GREATEST(
                                (
                                    CASE 
                                        WHEN is_present = 1 OR end_year IS NULL 
                                        THEN YEAR(CURDATE()) 
                                        ELSE end_year 
                                    END
                                ) - start_year,
                                0
                            )
                        ),
                        0
                    )
                ")
                ->whereColumn('cv_work_histories.cv_id', 'cvs.id');
        }, 'experience_years');

        // Keyword search: name, summary, descriptions
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('summary', 'like', "%{$keyword}%")
                    ->orWhereHas('educations', function ($edu) use ($keyword) {
                        $edu->where('description', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('workHistories', function ($work) use ($keyword) {
                        $work->where('company_name', 'like', "%{$keyword}%")
                            ->orWhere('job_title', 'like', "%{$keyword}%")
                            ->orWhere('job_description', 'like', "%{$keyword}%");
                    })
                    ->orWhereHas('certificates', function ($cert) use ($keyword) {
                        $cert->where('description', 'like', "%{$keyword}%");
                    });
            });
        }

        // CV category
        if ($request->filled('cv_category_id')) {
            $query->where('cv_category_id', $request->cv_category_id);
        }

        // Location: country and city
        if ($request->filled('country_id')) {
            $query->where('country_id', $request->country_id);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        // Skills: one or more, using AND logic
        $skillIds = array_filter((array) $request->input('skill_ids', []));

        $minimumRank = null;

        if ($request->filled('proficiency_level_id')) {
            $minimumRank = ProficiencyLevel::where('id', $request->proficiency_level_id)->value('rank');
        }

        foreach ($skillIds as $skillId) {
            $query->whereHas('skills', function ($skillQuery) use ($skillId, $minimumRank) {
                $skillQuery->where('skill_id', $skillId);

                if ($minimumRank !== null) {
                    $skillQuery->whereHas('proficiencyLevel', function ($levelQuery) use ($minimumRank) {
                        $levelQuery->where('rank', '>=', $minimumRank);
                    });
                }
            });
        }

        // Degree level
        if ($request->filled('degree_level_id')) {
            $query->whereHas('educations', function ($educationQuery) use ($request) {
                $educationQuery->where('degree_level_id', $request->degree_level_id);
            });
        }

        // Sorting
        if ($request->sort === 'alphabetical') {
            $query->orderBy('full_name', 'asc');
        } elseif ($request->sort === 'experience_desc') {
            $query->orderByDesc('experience_years');
        } else {
            $query->orderBy('updated_at', 'desc');
        }

        return view('cv.search', [
            'cvs' => $query->paginate(10)->withQueryString(),
            'cvCategories' => CvCategory::orderBy('name')->get(),
            'skills' => Skill::orderBy('name')->get(),
            'proficiencyLevels' => ProficiencyLevel::orderBy('rank')->get(),
            'countries' => Country::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'degreeLevels' => DegreeLevel::orderBy('name')->get(),
        ]);
    }
}