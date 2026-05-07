<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\CvCategory;
use App\Models\DegreeLevel;
use App\Models\Major;
use App\Models\Institution;
use App\Models\Industry;
use App\Models\CertificateName;
use App\Models\IssuingOrganization;
use App\Models\Skill;
use App\Models\ProficiencyLevel;
use App\Models\Country;
use App\Models\City;
use App\Models\District;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CvController extends Controller
{
    public function edit()
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Only job seekers can create or edit their own CV.');
        }

        $cv = Cv::with([
            'educations',
            'workHistories',
            'certificates',
            'skills',
        ])->where('user_id', auth()->id())->first();

        return view('cv.edit', [
            'cv' => $cv,
            'cvCategories' => CvCategory::orderBy('name')->get(),
            'degreeLevels' => DegreeLevel::orderBy('name')->get(),
            'majors' => Major::orderBy('name')->get(),
            'institutions' => Institution::orderBy('name')->get(),
            'industries' => Industry::orderBy('name')->get(),
            'employmentTypes' => JobType::orderBy('name')->get(),
            'certificateNames' => CertificateName::orderBy('name')->get(),
            'issuingOrganizations' => IssuingOrganization::orderBy('name')->get(),
            'skills' => Skill::orderBy('name')->get(),
            'proficiencyLevels' => ProficiencyLevel::orderBy('rank')->get(),
            'countries' => Country::orderBy('name')->get(),
            'cities' => City::orderBy('name')->get(),
            'districts' => District::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request)
    {
        if (auth()->user()->role !== 'user') {
            abort(403, 'Only job seekers can update their own CV.');
        }

        $request->validate([
            'cv_category_id' => 'required|exists:cv_categories,id',
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:Male,Female,Other',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:30',

            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'district_id' => 'nullable|exists:districts,id',
            'street_address' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:30',

            'summary' => 'nullable|string',
            'template' => 'required|in:modern,classic,minimal',

            'educations' => 'nullable|array',
            'work_histories' => 'nullable|array',
            'certificates' => 'nullable|array',

            'cv_skills' => 'required|array|min:1|max:5',
            'cv_skills.*.skill_id' => 'required|exists:skills,id',
            'cv_skills.*.proficiency_level_id' => 'required|exists:proficiency_levels,id',
        ]);

        DB::transaction(function () use ($request) {
            $cv = Cv::updateOrCreate(
                ['user_id' => auth()->id()],
                [
                    'cv_category_id' => $request->cv_category_id,
                    'full_name' => $request->full_name,
                    'date_of_birth' => $request->date_of_birth,
                    'gender' => $request->gender,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'country_id' => $request->country_id,
                    'city_id' => $request->city_id,
                    'district_id' => $request->district_id,
                    'street_address' => $request->street_address,
                    'postal_code' => $request->postal_code,
                    'summary' => $request->summary,
                    'template' => $request->template,
                ]
            );

            $cv->educations()->delete();
            $cv->workHistories()->delete();
            $cv->certificates()->delete();
            $cv->skills()->delete();

            foreach ($request->input('educations', []) as $education) {
                if (!empty($education['institution_id'])) {
                    $cv->educations()->create($education);
                }
            }

            foreach ($request->input('work_histories', []) as $work) {
                if (!empty($work['company_name'])) {
                    $work['is_present'] = isset($work['is_present']);
                    $cv->workHistories()->create($work);
                }
            }

            foreach ($request->input('certificates', []) as $certificate) {
                if (!empty($certificate['certificate_name_id'])) {
                    $cv->certificates()->create($certificate);
                }
            }

            foreach ($request->input('cv_skills', []) as $skill) {
                if (!empty($skill['skill_id'])) {
                    $cv->skills()->create($skill);
                }
            }
        });

        return redirect()->route('cv.edit')->with('success', 'CV saved successfully.');
    }

    public function show($id)
    {
        $cv = Cv::with([
            'user',
            'category',
            'country',
            'city',
            'district',
            'educations.institution',
            'educations.degreeLevel',
            'educations.major',
            'workHistories.jobType',
            'workHistories.industry',
            'certificates.certificateName',
            'certificates.issuingOrganization',
            'skills.skill',
            'skills.proficiencyLevel',
        ])->findOrFail($id);

        $isOwner = auth()->id() === $cv->user_id;
        $canViewAsEmployer = in_array(auth()->user()->role, ['employer', 'admin']);

        if (!$isOwner && !$canViewAsEmployer) {
            abort(403, 'You do not have permission to view this CV.');
        }

        $template = request('template');

        if (!in_array($template, ['modern', 'classic', 'minimal'])) {
            $template = $cv->template ?? 'modern';
        }

        return view('cv.show', compact('cv', 'template'));
    }
}