@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Dashboard</h4>
</div>

<div class="row g-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-primary bg-opacity-10 rounded p-3">
                    <i class="fas fa-users fa-lg text-primary"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Users</div>
                    <div class="fw-bold fs-5">{{ \App\Models\User::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-success bg-opacity-10 rounded p-3">
                    <i class="fas fa-briefcase fa-lg text-success"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Jobs</div>
                    <div class="fw-bold fs-5">{{ \App\Models\Job::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-warning bg-opacity-10 rounded p-3">
                    <i class="fas fa-file-alt fa-lg text-warning"></i>
                </div>
                <div>
                    <div class="text-muted small">Applications</div>
                    <div class="fw-bold fs-5">{{ \App\Models\JobApplication::count() }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="bg-info bg-opacity-10 rounded p-3">
                    <i class="fas fa-tags fa-lg text-info"></i>
                </div>
                <div>
                    <div class="text-muted small">Categories</div>
                    <div class="fw-bold fs-5">{{ \App\Models\Category::count() }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
