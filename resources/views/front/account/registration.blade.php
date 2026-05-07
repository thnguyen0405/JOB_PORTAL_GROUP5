@extends('front.layouts.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>

                    <form action="{{ route('account.processRegistration') }}" method="POST" name="registrationForm" id="registrationForm">
                        @csrf

                        <div class="mb-3">
                            <label class="mb-2">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email">
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Register As <span class="text-danger">*</span></label>
                            <select name="role" id="role" class="form-control">
                                <option value="">Select Account Type</option>
                                <option value="user">Job Seeker</option>
                                <option value="employer">Employer</option>
                            </select>
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            <p></p>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Please confirm Password">
                            <p></p>
                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>

                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
function showError(fieldId, message) {
    $("#" + fieldId)
        .addClass("is-invalid")
        .siblings("p")
        .addClass("invalid-feedback")
        .html(message);
}

function clearError(fieldId) {
    $("#" + fieldId)
        .removeClass("is-invalid")
        .siblings("p")
        .removeClass("invalid-feedback")
        .html("");
}

$("#registrationForm").submit(function(e) {
    e.preventDefault();

    $.ajax({
        url: '{{ route("account.processRegistration") }}',
        type: 'POST',
        data: $("#registrationForm").serializeArray(),
        dataType: 'json',
        success: function(response) {
            if (response.status == false) {
                var errors = response.errors;

                errors.name ? showError("name", errors.name[0]) : clearError("name");
                errors.email ? showError("email", errors.email[0]) : clearError("email");
                errors.role ? showError("role", errors.role[0]) : clearError("role");
                errors.password ? showError("password", errors.password[0]) : clearError("password");
                errors.confirm_password ? showError("confirm_password", errors.confirm_password[0]) : clearError("confirm_password");
            } else {
                clearError("name");
                clearError("email");
                clearError("role");
                clearError("password");
                clearError("confirm_password");

                window.location.href = '{{ route("account.login") }}';
            }
        },
        error: function() {
            alert("Something went wrong. Please try again.");
        }
    });
});
</script>
@endsection