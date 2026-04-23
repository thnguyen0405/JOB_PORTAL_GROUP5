@extends('admin.layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-bold">Edit User</h4>
    <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left me-1"></i> Back to Users
    </a>
</div>

<div class="card border-0 shadow-sm" style="max-width: 700px;">
    <div class="card-body p-4">
        <div id="alertBox"></div>
        <div id="editUserForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                    <input type="text" id="name" class="form-control" value="{{ $user->name }}">
                    <p class="text-danger small mt-1" id="name-error"></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" class="form-control" value="{{ $user->email }}">
                    <p class="text-danger small mt-1" id="email-error"></p>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Designation</label>
                    <input type="text" id="designation" class="form-control" value="{{ $user->designation }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mobile</label>
                    <input type="text" id="mobile" class="form-control" value="{{ $user->mobile }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Role</label>
                    <select id="role" class="form-select">
                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <button id="updateBtn" class="btn btn-primary px-4">
                    <i class="fas fa-save me-2"></i>Update User
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    $('#updateBtn').on('click', function () {
        // Clear previous errors
        $('.text-danger.small').text('');
        $('#alertBox').html('');

        const data = {
            name:        $('#name').val(),
            email:       $('#email').val(),
            designation: $('#designation').val(),
            mobile:      $('#mobile').val(),
            role:        $('#role').val(),
        };

        $.post('{{ route("admin.users.update", $user->id) }}', data, function (res) {
            if (res.status) {
                $('#alertBox').html('<div class="alert alert-success">' + res.message + '</div>');
                setTimeout(() => window.location.href = res.redirect, 1200);
            } else {
                $.each(res.errors, function (field, messages) {
                    $('#' + field + '-error').text(messages[0]);
                });
            }
        });
    });
});
</script>
@endsection
