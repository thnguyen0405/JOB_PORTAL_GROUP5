@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Jobs</h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>#ID</th>
                    <th>Title</th>
                    <th>Created by</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if ($jobs->isNotEmpty())
                    @foreach ($jobs as $job)
                        <tr>
                            <td>{{ $job->id }}</td>
                            <td>
                                <p> {{ $job->title }}</p>
                                <p> Applicants: {{ $job->applications->count() }} </p>
                            </td>
                            <td>{{ $job->user->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</td>
                            <td>
                                <span class="badge bg-{{ $job->status == 1 ? 'success' : 'secondary' }}">
                                    {{ $job->status == 1 ? 'Active' : 'Blocked' }}
                                </span>
                            </td>
                            <td>
                                <div class="action-dots">
                                    <button href="#" class="btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.jobs.edit', $job->id) }}">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-danger delete-job" onclick="deleteJob({{ $job->id }})" href="#"
                                                data-id="{{ $job->id }}">
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
    {{ $jobs->links() }}
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $(document).on('click', '.delete-job', function (e) {
        e.preventDefault();
        if (!confirm('Are you sure you want to delete this job?')) return;

        const id = $(this).data('id');
        $.post('/admin/jobs/' + 'delete/' + id, function (res) {
            if (res.status) location.reload();
        });
    });
});
</script>
@endsection
