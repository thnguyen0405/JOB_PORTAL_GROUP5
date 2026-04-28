@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Job Applications</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Job Title</th>
                    <th>User</th>
                    <th>Employer</th>
                    <th>Applied Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($applications->isNotEmpty())
                    @foreach ($applications as $application)
                        <tr>
                            <td>{{ $application->job->title }}</td>
                            <td>{{ $application->user->name }}</td>
                            <td>{{ $application->employer->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M Y') }}</td>
                            <td>
                                <div class="action-dots">
                                    <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item text-danger delete-job" onclick="deleteJobApplication({{ $application->id }})" href="#"
                                                data-id="{{ $application->id }}">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="mt-3">
    {{ $applications->links() }}
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $(document).on('click', '.delete-job', function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this job application?')) return;

        const id = $(this).data('id');
        $.post('/admin/job-applications/delete/' + id, function (res) {
            if (res.status) location.reload();
        });
    });
});
</script>
@endsection
