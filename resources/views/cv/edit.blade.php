@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4 bg-white shadow-sm">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">CV Management</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3">
                @include('front.account.sidebar')
            </div>

            <div class="col-lg-9">
                @include('front.layouts.message')

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('cv.update') }}" method="POST">
                    @csrf

                    @php
                        $educations = old('educations', $cv && $cv->educations ? $cv->educations->toArray() : [[]]);
                        $workHistories = old('work_histories', $cv && $cv->workHistories ? $cv->workHistories->toArray() : [[]]);
                        $certificates = old('certificates', $cv && $cv->certificates ? $cv->certificates->toArray() : [[]]);
                        $cvSkills = old('cv_skills', $cv && $cv->skills ? $cv->skills->toArray() : [[]]);
                    @endphp

                    {{-- PERSONAL INFORMATION --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white">
                            <h4 class="mb-0">Personal Information</h4>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="full_name" class="form-control"
                                           value="{{ old('full_name', $cv->full_name ?? auth()->user()->name ?? '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">CV Category <span class="text-danger">*</span></label>
                                    <select name="cv_category_id" class="form-control">
                                        <option value="">Select CV Category</option>
                                        @foreach($cvCategories as $category)
                                            <option value="{{ $category->id }}"
                                                @selected(old('cv_category_id', $cv->cv_category_id ?? '') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                           value="{{ old('date_of_birth', $cv->date_of_birth ?? '') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Select Gender</option>
                                        <option value="Male" @selected(old('gender', $cv->gender ?? '') == 'Male')>Male</option>
                                        <option value="Female" @selected(old('gender', $cv->gender ?? '') == 'Female')>Female</option>
                                        <option value="Other" @selected(old('gender', $cv->gender ?? '') == 'Other')>Other</option>
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Template <span class="text-danger">*</span></label>
                                    <select name="template" class="form-control">
                                        <option value="modern" @selected(old('template', $cv->template ?? '') == 'modern')>Modern</option>
                                        <option value="classic" @selected(old('template', $cv->template ?? '') == 'classic')>Classic</option>
                                        <option value="minimal" @selected(old('template', $cv->template ?? '') == 'minimal')>Minimal</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control"
                                           value="{{ old('email', $cv->email ?? auth()->user()->email ?? '') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <input type="text" name="phone_number" class="form-control"
                                           value="{{ old('phone_number', $cv->phone_number ?? '') }}">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Professional Summary</label>
                                    <textarea name="summary" class="form-control" rows="4"
                                              placeholder="Write a short professional summary...">{{ old('summary', $cv->summary ?? '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- STRUCTURED ADDRESS --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white">
                            <h4 class="mb-0">Structured Contact Address</h4>
                        </div>

                        <div class="card-body">
                            <div class="alert alert-info">
                                Address is stored in separate fields to support searching and filtering.
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Country <span class="text-danger">*</span></label>
                                    <select name="country_id" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}"
                                                @selected(old('country_id', $cv->country_id ?? '') == $country->id)>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">City / Province <span class="text-danger">*</span></label>
                                    <select name="city_id" class="form-control">
                                        <option value="">Select City</option>
                                        @foreach($cities as $city)
                                            <option value="{{ $city->id }}"
                                                @selected(old('city_id', $cv->city_id ?? '') == $city->id)>
                                                {{ $city->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">District</label>
                                    <select name="district_id" class="form-control">
                                        <option value="">Select District</option>
                                        @foreach($districts as $district)
                                            <option value="{{ $district->id }}"
                                                @selected(old('district_id', $cv->district_id ?? '') == $district->id)>
                                                {{ $district->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Street Address <span class="text-danger">*</span></label>
                                    <input type="text" name="street_address" class="form-control"
                                           value="{{ old('street_address', $cv->street_address ?? '') }}">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Postal Code</label>
                                    <input type="text" name="postal_code" class="form-control"
                                           value="{{ old('postal_code', $cv->postal_code ?? '') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EDUCATION --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Education</h4>
                            <button type="button" class="btn btn-sm btn-primary" id="addEducation">Add Degree</button>
                        </div>

                        <div class="card-body" id="educationWrapper">
                            @foreach($educations as $index => $education)
                                <div class="repeat-box border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Degree Record</strong>
                                        <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Institution</label>
                                            <select name="educations[{{ $index }}][institution_id]" class="form-control">
                                                <option value="">Select Institution</option>
                                                @foreach($institutions as $institution)
                                                    <option value="{{ $institution->id }}"
                                                        @selected(($education['institution_id'] ?? '') == $institution->id)>
                                                        {{ $institution->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Degree Level</label>
                                            <select name="educations[{{ $index }}][degree_level_id]" class="form-control">
                                                <option value="">Select Degree</option>
                                                @foreach($degreeLevels as $degree)
                                                    <option value="{{ $degree->id }}"
                                                        @selected(($education['degree_level_id'] ?? '') == $degree->id)>
                                                        {{ $degree->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Major</label>
                                            <select name="educations[{{ $index }}][major_id]" class="form-control">
                                                <option value="">Select Major</option>
                                                @foreach($majors as $major)
                                                    <option value="{{ $major->id }}"
                                                        @selected(($education['major_id'] ?? '') == $major->id)>
                                                        {{ $major->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Start Year</label>
                                            <input type="number" name="educations[{{ $index }}][start_year]" class="form-control"
                                                   value="{{ $education['start_year'] ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>End Year</label>
                                            <input type="number" name="educations[{{ $index }}][end_year]" class="form-control"
                                                   value="{{ $education['end_year'] ?? '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Description</label>
                                            <input type="text" name="educations[{{ $index }}][description]" class="form-control"
                                                   value="{{ $education['description'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- WORK HISTORY --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Work History</h4>
                            <button type="button" class="btn btn-sm btn-primary" id="addWork">Add Work History</button>
                        </div>

                        <div class="card-body" id="workWrapper">
                            @foreach($workHistories as $index => $work)
                                <div class="repeat-box border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Work Record</strong>
                                        <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Company Name</label>
                                            <input type="text" name="work_histories[{{ $index }}][company_name]" class="form-control"
                                                   value="{{ $work['company_name'] ?? '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Job Title</label>
                                            <input type="text" name="work_histories[{{ $index }}][job_title]" class="form-control"
                                                   value="{{ $work['job_title'] ?? '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Employment Type</label>
                                            <select name="work_histories[{{ $index }}][employment_type_id]" class="form-control">
                                                <option value="">Select Type</option>
                                                @foreach($employmentTypes as $type)
                                                    <option value="{{ $type->id }}"
                                                        @selected(($work['employment_type_id'] ?? '') == $type->id)>
                                                        {{ $type->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Industry</label>
                                            <select name="work_histories[{{ $index }}][industry_id]" class="form-control">
                                                <option value="">Select Industry</option>
                                                @foreach($industries as $industry)
                                                    <option value="{{ $industry->id }}"
                                                        @selected(($work['industry_id'] ?? '') == $industry->id)>
                                                        {{ $industry->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Start Year</label>
                                            <input type="number" name="work_histories[{{ $index }}][start_year]" class="form-control"
                                                   value="{{ $work['start_year'] ?? '' }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>End Year</label>
                                            <input type="number" name="work_histories[{{ $index }}][end_year]" class="form-control"
                                                   value="{{ $work['end_year'] ?? '' }}">
                                        </div>

                                        <div class="col-md-6 mb-3 d-flex align-items-end">
                                            <div class="form-check">
                                                <input type="checkbox" name="work_histories[{{ $index }}][is_present]" value="1"
                                                       class="form-check-input"
                                                       @checked(!empty($work['is_present']))>
                                                <label class="form-check-label">Currently working here</label>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Job Description</label>
                                            <textarea name="work_histories[{{ $index }}][job_description]" class="form-control" rows="3">{{ $work['job_description'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- CERTIFICATES --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">Certificates</h4>
                            <button type="button" class="btn btn-sm btn-primary" id="addCertificate">Add Certificate</button>
                        </div>

                        <div class="card-body" id="certificateWrapper">
                            @foreach($certificates as $index => $certificate)
                                <div class="repeat-box border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Certificate Record</strong>
                                        <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>Certificate Name</label>
                                            <select name="certificates[{{ $index }}][certificate_name_id]" class="form-control">
                                                <option value="">Select Certificate</option>
                                                @foreach($certificateNames as $certificateName)
                                                    <option value="{{ $certificateName->id }}"
                                                        @selected(($certificate['certificate_name_id'] ?? '') == $certificateName->id)>
                                                        {{ $certificateName->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Issuing Organization</label>
                                            <select name="certificates[{{ $index }}][issuing_organization_id]" class="form-control">
                                                <option value="">Select Organization</option>
                                                @foreach($issuingOrganizations as $organization)
                                                    <option value="{{ $organization->id }}"
                                                        @selected(($certificate['issuing_organization_id'] ?? '') == $organization->id)>
                                                        {{ $organization->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label>Year Issued</label>
                                            <input type="number" name="certificates[{{ $index }}][year_issued]" class="form-control"
                                                   value="{{ $certificate['year_issued'] ?? '' }}">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label>Description</label>
                                            <input type="text" name="certificates[{{ $index }}][description]" class="form-control"
                                                   value="{{ $certificate['description'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SKILLS --}}
                    <div class="card border-0 shadow mb-4">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">Strongest Skills</h4>
                                <small class="text-muted">Maximum 5 skills. Free-text skills are not allowed.</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="addSkill">Add Skill</button>
                        </div>

                        <div class="card-body" id="skillWrapper">
                            @foreach($cvSkills as $index => $skillRow)
                                <div class="repeat-box border rounded p-3 mb-3 skill-box">
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Skill Record</strong>
                                        <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label>Skill</label>
                                            <select name="cv_skills[{{ $index }}][skill_id]" class="form-control">
                                                <option value="">Select Skill</option>
                                                @foreach($skills as $skill)
                                                    <option value="{{ $skill->id }}"
                                                        @selected(($skillRow['skill_id'] ?? '') == $skill->id)>
                                                        {{ $skill->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Proficiency Level</label>
                                            <select name="cv_skills[{{ $index }}][proficiency_level_id]" class="form-control">
                                                <option value="">Select Level</option>
                                                @foreach($proficiencyLevels as $level)
                                                    <option value="{{ $level->id }}"
                                                        @selected(($skillRow['proficiency_level_id'] ?? '') == $level->id)>
                                                        {{ $level->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-primary">Save CV</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>

{{-- Templates for JavaScript --}}
<template id="educationTemplate">
    <div class="repeat-box border rounded p-3 mb-3">
        <div class="d-flex justify-content-between mb-3">
            <strong>Degree Record</strong>
            <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Institution</label>
                <select name="educations[__INDEX__][institution_id]" class="form-control">
                    <option value="">Select Institution</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}">{{ $institution->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Degree Level</label>
                <select name="educations[__INDEX__][degree_level_id]" class="form-control">
                    <option value="">Select Degree</option>
                    @foreach($degreeLevels as $degree)
                        <option value="{{ $degree->id }}">{{ $degree->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Major</label>
                <select name="educations[__INDEX__][major_id]" class="form-control">
                    <option value="">Select Major</option>
                    @foreach($majors as $major)
                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Start Year</label>
                <input type="number" name="educations[__INDEX__][start_year]" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>End Year</label>
                <input type="number" name="educations[__INDEX__][end_year]" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Description</label>
                <input type="text" name="educations[__INDEX__][description]" class="form-control">
            </div>
        </div>
    </div>
</template>

<template id="workTemplate">
    <div class="repeat-box border rounded p-3 mb-3">
        <div class="d-flex justify-content-between mb-3">
            <strong>Work Record</strong>
            <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Company Name</label>
                <input type="text" name="work_histories[__INDEX__][company_name]" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Job Title</label>
                <input type="text" name="work_histories[__INDEX__][job_title]" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>Employment Type</label>
                <select name="work_histories[__INDEX__][employment_type_id]" class="form-control">
                    <option value="">Select Type</option>
                    @foreach($employmentTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Industry</label>
                <select name="work_histories[__INDEX__][industry_id]" class="form-control">
                    <option value="">Select Industry</option>
                    @foreach($industries as $industry)
                        <option value="{{ $industry->id }}">{{ $industry->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3 mb-3">
                <label>Start Year</label>
                <input type="number" name="work_histories[__INDEX__][start_year]" class="form-control">
            </div>

            <div class="col-md-3 mb-3">
                <label>End Year</label>
                <input type="number" name="work_histories[__INDEX__][end_year]" class="form-control">
            </div>

            <div class="col-md-6 mb-3 d-flex align-items-end">
                <div class="form-check">
                    <input type="checkbox" name="work_histories[__INDEX__][is_present]" value="1" class="form-check-input">
                    <label class="form-check-label">Currently working here</label>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label>Job Description</label>
                <textarea name="work_histories[__INDEX__][job_description]" class="form-control" rows="3"></textarea>
            </div>
        </div>
    </div>
</template>

<template id="certificateTemplate">
    <div class="repeat-box border rounded p-3 mb-3">
        <div class="d-flex justify-content-between mb-3">
            <strong>Certificate Record</strong>
            <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Certificate Name</label>
                <select name="certificates[__INDEX__][certificate_name_id]" class="form-control">
                    <option value="">Select Certificate</option>
                    @foreach($certificateNames as $certificateName)
                        <option value="{{ $certificateName->id }}">{{ $certificateName->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Issuing Organization</label>
                <select name="certificates[__INDEX__][issuing_organization_id]" class="form-control">
                    <option value="">Select Organization</option>
                    @foreach($issuingOrganizations as $organization)
                        <option value="{{ $organization->id }}">{{ $organization->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Year Issued</label>
                <input type="number" name="certificates[__INDEX__][year_issued]" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <label>Description</label>
                <input type="text" name="certificates[__INDEX__][description]" class="form-control">
            </div>
        </div>
    </div>
</template>

<template id="skillTemplate">
    <div class="repeat-box border rounded p-3 mb-3 skill-box">
        <div class="d-flex justify-content-between mb-3">
            <strong>Skill Record</strong>
            <button type="button" class="btn btn-sm btn-danger remove-box">Remove</button>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Skill</label>
                <select name="cv_skills[__INDEX__][skill_id]" class="form-control">
                    <option value="">Select Skill</option>
                    @foreach($skills as $skill)
                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Proficiency Level</label>
                <select name="cv_skills[__INDEX__][proficiency_level_id]" class="form-control">
                    <option value="">Select Level</option>
                    @foreach($proficiencyLevels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</template>
@endsection

@section('customJs')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let educationIndex = document.querySelectorAll('#educationWrapper .repeat-box').length;
    let workIndex = document.querySelectorAll('#workWrapper .repeat-box').length;
    let certificateIndex = document.querySelectorAll('#certificateWrapper .repeat-box').length;
    let skillIndex = document.querySelectorAll('#skillWrapper .skill-box').length;

    function addTemplate(templateId, wrapperId, index) {
        const template = document.getElementById(templateId).innerHTML;
        const html = template.replaceAll('__INDEX__', index);
        document.getElementById(wrapperId).insertAdjacentHTML('beforeend', html);
    }

    document.getElementById('addEducation').addEventListener('click', function () {
        addTemplate('educationTemplate', 'educationWrapper', educationIndex);
        educationIndex++;
    });

    document.getElementById('addWork').addEventListener('click', function () {
        addTemplate('workTemplate', 'workWrapper', workIndex);
        workIndex++;
    });

    document.getElementById('addCertificate').addEventListener('click', function () {
        addTemplate('certificateTemplate', 'certificateWrapper', certificateIndex);
        certificateIndex++;
    });

    document.getElementById('addSkill').addEventListener('click', function () {
        const skillCount = document.querySelectorAll('#skillWrapper .skill-box').length;

        if (skillCount >= 5) {
            alert('You can only add a maximum of 5 strongest skills.');
            return;
        }

        addTemplate('skillTemplate', 'skillWrapper', skillIndex);
        skillIndex++;
    });

    document.addEventListener('click', function (event) {
        if (event.target.classList.contains('remove-box')) {
            event.target.closest('.repeat-box').remove();
        }
    });
});
</script>
@endsection