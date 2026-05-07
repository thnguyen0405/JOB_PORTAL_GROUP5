@extends('front.layouts.app')

@section('main')
<section class="section-5 bg-2">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                @include('front.account.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 fw-bold">Saved Jobs</h4>

                        @include('front.layouts.message')

                        <div id="savedJobsContainer">
                        @forelse ($savedJobs as $savedJob)
                        <div class="job-item d-flex align-items-start border rounded p-3 mb-3 saved-row-{{ $savedJob->id }}">
                            <div class="flex-grow-1">
                                <h5 class="mb-1">
                                    <a href="{{ route('jobDetail', $savedJob->job->id) }}" class="text-dark text-decoration-none">
                                        {{ $savedJob->job->title }}
                                    </a>
                                </h5>
                                <p class="text-muted mb-1">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $savedJob->job->location }}
                                </p>
                                <small class="text-muted">Saved on {{ \Carbon\Carbon::parse($savedJob->created_at)->format('d M, Y') }}</small>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-outline-danger remove-saved-job" data-id="{{ $savedJob->id }}">
                                    <i class="fas fa-times me-1"></i>Remove
                                </button>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted" id="noSavedMsg">You have no saved jobs yet.</p>
                        @endforelse
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
$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $(document).on('click', '.remove-saved-job', function () {
        if (!confirm('Remove this saved job?')) return;

        const id  = $(this).data('id');
        const row = '.saved-row-' + id;

        $.post('{{ route("account.removeSavedJob") }}', { id: id }, function (res) {
            if (res.status) {
                $(row).fadeOut(300, function () {
                    $(this).remove();
                    if ($('.job-item').length === 0) {
                        $('#savedJobsContainer').html('<p class="text-muted">You have no saved jobs yet.</p>');
                    }
                });
            }
        });
    });
});
</script>
@endsection
