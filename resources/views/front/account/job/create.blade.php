@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">

        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class="rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
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

                <form action="" method="POST" id="createJobForm" name="createJobForm">
                    @csrf

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body card-form p-4">

                            <h3 class="fs-4 mb-3">Job Details</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Title <span class="req">*</span></label>
                                    <input type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Category <span class="req">*</span></label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">Select a Category</option>
                                        @if(isset($categories) && $categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Job Type <span class="req">*</span></label>
                                    <select name="jobType" id="jobType" class="form-control">
                                        <option value="">Select Job Type</option>
                                        @if(isset($job_types) && $job_types->isNotEmpty())
                                            @foreach($job_types as $job_type)
                                                <option value="{{ $job_type->id }}">{{ $job_type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Vacancy <span class="req">*</span></label>
                                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                    <p></p>
                                </div>
                            </div>

                            <h3 class="fs-4 mb-3 mt-4">Salary & Benefits</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Salary Range <span class="req">*</span></label>
                                    <select name="salary_range" id="salary_range" class="form-control">
                                        <option value="">Select Salary Range</option>
                                        <option value="under_500">Under 500 USD</option>
                                        <option value="500_1000">500 - 1000 USD</option>
                                        <option value="1000_1500">1000 - 1500 USD</option>
                                        <option value="1500_2000">1500 - 2000 USD</option>
                                        <option value="2000_plus">Above 2000 USD</option>
                                        <option value="negotiable">Negotiable</option>
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Salary Type <span class="req">*</span></label>
                                    <select name="salary_type" id="salary_type" class="form-control">
                                        <option value="">Select Salary Type</option>
                                        <option value="gross">Gross</option>
                                        <option value="net">Net</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <h3 class="fs-4 mb-3 mt-4">Job Location</h3>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">Country <span class="req">*</span></label>
                                    <select name="country_id" id="country_id" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach(($countries ?? collect()) as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">City / Province <span class="req">*</span></label>
                                    <select name="city_id" id="city_id" class="form-control">
                                        <option value="">Select City</option>
                                        @foreach(($cities ?? collect()) as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">District</label>
                                    <select name="district_id" id="district_id" class="form-control">
                                        <option value="">Select District</option>
                                        @foreach(($districts ?? collect()) as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">Work Arrangement <span class="req">*</span></label>
                                    <select name="work_arrangement" id="work_arrangement" class="form-control">
                                        <option value="">Select Work Arrangement</option>
                                        <option value="onsite">Onsite</option>
                                        <option value="remote">Remote</option>
                                        <option value="hybrid">Hybrid</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <h3 class="fs-4 mb-3 mt-4">Job Description</h3>

                            <div class="mb-4">
                                <label class="mb-2">Description <span class="req">*</span></label>
                                <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Benefits</label>
                                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Responsibility</label>
                                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Qualifications</label>
                                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Experience <span class="req">*</span></label>
                                <select name="experience" id="experience" class="form-control">
                                    <option value="">Select Experience</option>
                                    <option value="1">1 Year</option>
                                    <option value="2">2 Years</option>
                                    <option value="3">3 Years</option>
                                    <option value="4">4 Years</option>
                                    <option value="5">5 Years</option>
                                    <option value="6">6 Years</option>
                                    <option value="7">7 Years</option>
                                    <option value="8">8 Years</option>
                                    <option value="9">9 Years</option>
                                    <option value="10">10 Years</option>
                                    <option value="10_plus">10+ Years</option>
                                </select>
                                <p></p>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Keywords</label>
                                <input type="text" placeholder="Keywords" id="keywords" name="keywords" class="form-control">
                            </div>

                            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="mb-2">Name <span class="req">*</span></label>
                                    <input type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                    <p></p>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">Company Country <span class="req">*</span></label>
                                    <select name="company_country_id" id="company_country_id" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach(($countries ?? collect()) as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">Company City <span class="req">*</span></label>
                                    <select name="company_city_id" id="company_city_id" class="form-control">
                                        <option value="">Select City</option>
                                        @foreach(($cities ?? collect()) as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>

                                <div class="col-md-4 mb-4">
                                    <label class="mb-2">Company District</label>
                                    <select name="company_district_id" id="company_district_id" class="form-control">
                                        <option value="">Select District</option>
                                        @foreach(($districts ?? collect()) as $district)
                                            <option value="{{ $district->id }}">{{ $district->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="mb-2">Website</label>
                                <input type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                            </div>

                        </div>

                        <div class="card-footer p-4">
                            <button type="submit" class="btn btn-primary" id="saveJobBtn">Save Job</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script type="text/javascript">
$(document).ready(function () {

    if ($.fn.trumbowyg) {
        $('#description').trumbowyg();
        $('#benefits').trumbowyg();
        $('#responsibility').trumbowyg();
        $('#qualifications').trumbowyg();
    }

    function showError(field, message) {
        $("#" + field).addClass('is-invalid');
        $("#" + field).siblings('p').addClass('invalid-feedback').html(message);
    }

    function clearError(field) {
        $("#" + field).removeClass('is-invalid');
        $("#" + field).siblings('p').removeClass('invalid-feedback').html('');
    }

    function clearAllErrors() {
        let fields = [
            'title',
            'category',
            'jobType',
            'vacancy',
            'salary_range',
            'salary_type',
            'country_id',
            'city_id',
            'district_id',
            'work_arrangement',
            'description',
            'experience',
            'company_name',
            'company_country_id',
            'company_city_id',
            'company_district_id'
        ];

        fields.forEach(function(field) {
            clearError(field);
        });
    }

    function showValidationErrors(errors) {
        let fields = [
            'title',
            'category',
            'jobType',
            'vacancy',
            'salary_range',
            'salary_type',
            'country_id',
            'city_id',
            'district_id',
            'work_arrangement',
            'description',
            'experience',
            'company_name',
            'company_country_id',
            'company_city_id',
            'company_district_id'
        ];

        fields.forEach(function(field) {
            if (errors && errors[field]) {
                showError(field, errors[field][0]);
            } else {
                clearError(field);
            }
        });
    }

    $("#createJobForm").submit(function(e) {
        e.preventDefault();

        clearAllErrors();

        $("#saveJobBtn").prop('disabled', true).text('Saving...');

        $.ajax({
            url: '{{ route("account.saveJob") }}',
            type: 'POST',
            dataType: 'json',
            data: $("#createJobForm").serialize(),

            success: function(response) {
                $("#saveJobBtn").prop('disabled', false).text('Save Job');

                if (response.status === true) {
                    clearAllErrors();
                    window.location.href = "{{ route('account.myJobs') }}";
                } else {
                    showValidationErrors(response.errors);
                }
            },

            error: function(xhr) {
                $("#saveJobBtn").prop('disabled', false).text('Save Job');

                console.log("Status:", xhr.status);
                console.log("Response:", xhr.responseText);

                if (xhr.status === 419) {
                    alert("CSRF token expired. Please refresh the page and try again.");
                    return;
                }

                if (xhr.status === 500) {
                    alert("Server error 500. Please check your Laravel terminal. It may be a missing database column or controller issue.");
                    return;
                }

                alert("Error " + xhr.status + ". Please check browser console and Laravel terminal.");
            }
        });
    });

});
</script>
@endsection