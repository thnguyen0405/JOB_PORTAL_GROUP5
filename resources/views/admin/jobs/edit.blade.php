@extends('admin.layouts.app')

@section('content')

<div class="col-lg-9">
    <div id="editJobForm">
            <div class="card border-0 shadow mb-4 ">
                <div class="card-body px-5 py-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fs-4 mb-0">Edit Job Details</h3>

                        <a href="{{ route('admin.jobs') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Jobs
                        </a>
                    </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Title<span class="req">*</span></label>
                                <input value = "{{ $job->title }}"type="text" placeholder="Job Title" id="title" name="title" class="form-control">
                            <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Category<span class="req">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @if ($categories->isNotEmpty())
                                        @foreach ($categories as $category)
                                            <option {{ $job->category_id == $category->id ? 'selected' 
                                            : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <p></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="" class="mb-2">Job Type<span class="req">*</span></label>
                                <select name="jobType" id="jobType" class="form-control">
                                    <option value="">Select Job Type</option>

                                    @if($job_types->isNotEmpty())
                                        @foreach($job_types as $job_type)
                                            <option {{ $job->job_type_id == $job_type->id ? 'selected' : '' }} value="{{ $job_type->id }}">
                                                {{ $job_type->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            <p></p>
                            </div>
                            <div class="col-md-6  mb-4">
                                <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                                <input value="{{ $job->vacancy }}" type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Salary</label>
                                <input value="{{ $job->salary }}" type="text" placeholder="Salary" id="salary" name="salary" class="form-control">
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location<span class="req">*</span></label>
                                <input value="{{ $job->location }}" type="text" placeholder="Location" id="location" name="location" class="form-control">
                                <p></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <div class="form-check">
                                    <input {{ $job->isFeatured == 1 ? 'checked' : '' }} class="form-check-input" type="checkbox" value="1" id="isFeatured" name = "isFeatured">
                                    <label class="form-check-label" for="isFeatured">
                                        Featured
                                    </label>
                                </div>
                            </div>
                            <div class="mb-4 col-md-6">
                            <div class="form-check-inline">
                                <input {{ $job->status == 1 ? 'checked' : '' }} class="form-check-input" type="radio" value="1" id="status-active" name = "status">
                                <label class="form-check-label" for="status-active">
                                    Active
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <input {{ $job->status == 0 ? 'checked' : '' }} class="form-check-input" type="radio" value="0" id="status-block" name = "status">
                                <label class="form-check-label" for="status-block">
                                    Blocked
                                </label>
                            </div>
                        </div> 

                        <div class="mb-4">
                            <label for="" class="mb-2">Description<span class="req">*</span></label>
                            <textarea class="form-control" name="description" id="description" cols="5" rows="5" placeholder="Description">{{ $job->description }}</textarea>
                            <p></p>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Benefits</label>
                            <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits">{{ $job->benefits }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Responsibility</label>
                            <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Qualifications</label>
                            <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="" class="mb-2">Experience<span class="req">*</span></label>
                            <select name="experience" id="experience" class="form-control">
                                <option value="1" {{ $job->experience == 1 ? 'selected' : '' }}>1 Year</option>
                            <option value="2" {{ $job->experience == 2 ? 'selected' : '' }}>2 Years</option>
                            <option value="3" {{ $job->experience == 3 ? 'selected' : '' }}>3 Years</option>
                            <option value="4" {{ $job->experience == 4 ? 'selected' : '' }}>4 Years</option>
                            <option value="5" {{ $job->experience == 5 ? 'selected' : '' }}>5 Years</option>
                            <option value="6" {{ $job->experience == 6 ? 'selected' : '' }}>6 Years</option>
                            <option value="7" {{ $job->experience == 7 ? 'selected' : '' }}>7 Years</option>
                            <option value="8" {{ $job->experience == 8 ? 'selected' : '' }}>8 Years</option>
                            <option value="9" {{ $job->experience == 9 ? 'selected' : '' }}>9 Years</option>
                            <option value="10" {{ $job->experience == 10 ? 'selected' : '' }}>10 Years</option>
                            <option value="10_plus" {{ $job->experience == '10_plus' ? 'selected' : '' }}>10+ Years</option>
                            </select>
                            <p></p>
                        </div>
                        
                        

                        <div class="mb-4">
                            <label for="" class="mb-2">Keywords</label>
                            <input value="{{ $job->keywords }}" type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                        </div>

                        <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Name<span class="req">*</span></label>
                                <input value="{{ $job->company_name }}" type="text" placeholder="Company Name" id="company_name" name="company_name" class="form-control">
                                <p></p>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label for="" class="mb-2">Location</label>
                                <input value="{{ $job->company_location }}" type="text" placeholder="Location" id="company_location" name="company_location" class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="mb-2">Website</label>
                            <input value="{{ $job->company_website }}" type="text" placeholder="Website" id="company_website" name="company_website" class="form-control">
                        </div>
                    </div> 
                    <div class="card-footer  p-4">
                        <button type="button" id="updateJobBtn" class="btn btn-primary">Update Job</button>
                    </div>               
                </div>
            </div>
    </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $('#updateJobBtn').on('click', function () {
        
        $("button").prop('disabled', true);

        $.ajax({
            url: '{{ route("admin.jobs.update", $job->id) }}',
            type: 'POST',
            dataType: 'json',
            data: $("#editJobForm :input").serialize(),
            success: function(response) {
            $("button").prop('disabled', false);

                if(response.status == true) {

                    $("#title").removeClass('is-invalid');
                    $("#title").siblings('p').removeClass('invalid-feedback').html('');

                    $("#category").removeClass('is-invalid');
                    $("#category").siblings('p').removeClass('invalid-feedback').html('');
                    // jobType
                    $("#jobType").removeClass('is-invalid');
                    $("#jobType").siblings('p').removeClass('invalid-feedback').html('');

                    // vacancy
                    $("#vacancy").removeClass('is-invalid');
                    $("#vacancy").siblings('p').removeClass('invalid-feedback').html('');

                    // location
                    $("#location").removeClass('is-invalid');
                    $("#location").siblings('p').removeClass('invalid-feedback').html('');

                    // description
                    $("#description").removeClass('is-invalid');
                    $("#description").siblings('p').removeClass('invalid-feedback').html('');

                    // company_name
                    $("#company_name").removeClass('is-invalid');
                    $("#company_name").siblings('p').removeClass('invalid-feedback').html('');
                    if(response.status == true) {
                        window.location.href = "{{ route('admin.jobs') }}";
                    }
                    //location.reload();
                } else {

                    var errors = response.errors;

                    if(errors.title) {
                        $("#title").addClass('is-invalid');
                        $("#title").siblings('p').addClass('invalid-feedback').html(errors.title[0]);
                    } else {
                        $("#title").removeClass('is-invalid');
                        $("#title").siblings('p').removeClass('invalid-feedback').html('');
                    }

                    if(errors.category) {
                        $("#category").addClass('is-invalid');
                        $("#category").siblings('p').addClass('invalid-feedback').html(errors.category[0]);
                    } else {
                        $("#category").removeClass('is-invalid');
                        $("#category").siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.jobType) {
                        $("#jobType").addClass('is-invalid');
                        $("#jobType").siblings('p').addClass('invalid-feedback').html(errors.jobType[0]);
                    } else {
                        $("#jobType").removeClass('is-invalid');
                        $("#jobType").siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.vacancy) {
                        $("#vacancy").addClass('is-invalid');
                        $("#vacancy").siblings('p').addClass('invalid-feedback').html(errors.vacancy[0]);
                    } else {
                        $("#vacancy").removeClass('is-invalid');
                        $("#vacancy").siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.location) {
                        $("#location").addClass('is-invalid');
                        $("#location").siblings('p').addClass('invalid-feedback').html(errors.location[0]);
                    } else {
                        $("#location").removeClass('is-invalid');
                        $("#location").siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.description) {
                        $("#description").addClass('is-invalid');
                        $("#description").siblings('p').addClass('invalid-feedback').html(errors.description[0]);
                    } else {
                        $("#description").removeClass('is-invalid');
                        $("#description").siblings('p').removeClass('invalid-feedback').html('');
                    }
                    if(errors.company_name) {
                        $("#company_name").addClass('is-invalid');
                        $("#company_name").siblings('p').addClass('invalid-feedback').html(errors.company_name[0]);
                    } else {
                        $("#company_name").removeClass('is-invalid');
                        $("#company_name").siblings('p').removeClass('invalid-feedback').html('');
                    }
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    });

        $('#description').trumbowyg();
        $('#benefits').trumbowyg();
        $('#responsibility').trumbowyg();
        $('#qualifications').trumbowyg();
        function deleteJob(id) {
            if (confirm('Are you sure you want to delete this job?')) {
                $.ajax({
                    url: '{{ route("admin.jobs.delete", $job->id) }}/',
                    type: 'delete',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = '{{ route("admin.jobs") }}';
                    }
                });
            }
        }
</script>
@endsection
