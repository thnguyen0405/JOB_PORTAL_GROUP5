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
                        <h4 class="card-title mb-4 fw-bold">Change Password</h4>

                        @include('front.layouts.message')

                        <div id="alertBox"></div>

                        <div class="row g-3" style="max-width: 500px;">
                            <div class="col-12">
                                <label class="form-label fw-semibold">Old Password <span class="text-danger">*</span></label>
                                <input type="password" id="old_password" class="form-control" placeholder="Enter old password">
                                <p class="text-danger small mt-1" id="old_password-error"></p>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                                <input type="password" id="new_password" class="form-control" placeholder="At least 5 characters">
                                <p class="text-danger small mt-1" id="new_password-error"></p>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" id="confirm_password" class="form-control" placeholder="Repeat new password">
                                <p class="text-danger small mt-1" id="confirm_password-error"></p>
                            </div>
                            <div class="col-12 mt-2">
                                <button id="changePasswordBtn" class="btn btn-primary px-4">Update Password</button>
                            </div>
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

    $('#changePasswordBtn').on('click', function () {
        $('.text-danger.small').text('');
        $('#alertBox').html('');

        const data = {
            old_password:     $('#old_password').val(),
            new_password:     $('#new_password').val(),
            confirm_password: $('#confirm_password').val(),
        };

        $.post('{{ route("account.updatePassword") }}', data, function (res) {
            if (res.status) {
                $('#alertBox').html('<div class="alert alert-success">' + res.message + '</div>');
                $('#old_password, #new_password, #confirm_password').val('');
            } else {
                $.each(res.errors, function (field, msgs) {
                    $('#' + field + '-error').text(msgs[0]);
                });
            }
        });
    });
});
</script>
@endsection
