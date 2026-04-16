@extends('front.layouts.app')

@section('main')
<section class="section-4 bg-2">    
    <div class="container pt-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url()->previous() }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Jobs</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="container job_details_area">
        <div class="row pb-5">
            <div class="col-md-8">
                <div class="card shadow border-0 p-4">
                    <div class="job_details_header">
                        <div class="single_jobs white-bg d-flex justify-content-between">
                            <div class="jobs_left d-flex align-items-center">
                                
                                <div class="jobs_conetent">
                                    <a href="#">
                                        <h4 class="text-primary mb-3">{{ $job->title }}</h4>
                                    </a>
                                    <div class="links_locat d-flex align-items-center mb-4">
                                        <div class="location me-3">
                                            <p class="mb-0 text-muted"> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                        </div>
                                        <div class="location">
                                            <p class="mb-0 text-muted"> <i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="descript_wrap white-bg mt-3">
                        <div class="single_wrap mb-4">
                            <h5 class="fw-bolder">Job description</h5>
                            <p class="text-muted">{!! nl2br(e($job->description)) !!}</p>
                        </div>
                        @if (!empty($job->responsibility))
                        <div class="single_wrap mb-4">
                            <h5 class="fw-bolder">Responsibility</h5>
                            <p class="text-muted">{!! nl2br(e($job->responsibility)) !!}</p>
                        </div>
                        @endif
                        @if (!empty($job->qualifications))
                        <div class="single_wrap mb-4">
                            <h5 class="fw-bolder">Qualifications</h5>
                            <p class="text-muted">{!! nl2br(e($job->qualifications)) !!}</p>
                        </div>
                        @endif
                        <div class="pt-3 text-end mt-5">
                            <a href="#" class="btn btn-secondary px-4 me-2">Save</a>
                            <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary px-4">Apply</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow border-0 p-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-2">
                            <h4 class="fw-bold text-primary">Job Summery</h4>
                        </div>
                        <div class="job_content pt-3">
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Published on: <span class="fw-bolder text-dark">{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Vacancy: <span class="fw-bolder text-dark">{{ $job->vacancy }}</span></li>
                                @if (!empty($job->salary))
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Salary: <span class="fw-bolder text-dark">{{ $job->salary }}</span></li>
                                @endif
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Location: <span class="fw-bolder text-dark">{{ $job->location }}</span></li>
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Job Nature: <span class="fw-bolder text-dark">{{ $job->jobType->name }}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow border-0 my-4 p-4">
                    <div class="job_sumary">
                        <div class="summery_header pb-1 pt-2">
                            <h4 class="fw-bold text-primary">Company Details</h4>
                        </div>
                        <div class="job_content pt-3Text">
                            <ul class="list-unstyled text-muted">
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Name: <span class="fw-bolder text-dark">{{ $job->company_name }}</span></li>
                                @if (!empty($job->company_location))
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Location: <span class="fw-bolder text-dark">{{ $job->company_location }}</span></li>
                                @endif
                                @if (!empty($job->company_website))
                                <li class="mb-2"><i class="fa fa-circle-o me-2" style="font-size: 10px;"></i>Website: <span><a href="{{ $job->company_website }}" class="fw-bolder text-primary text-decoration-none">{{ $job->company_website }}</a></span></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
function applyJob(id) {
    if (confirm("Are you sure you want to apply for this job?")) {
        $.ajax({
            url: '{{ route("applyJob") }}',
            type: 'post',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                } else {
                    alert(response.message);
                }
            }
        });
    }
}
</script>
@endsection
