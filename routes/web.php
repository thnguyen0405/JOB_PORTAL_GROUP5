<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobApplicationController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [JobsController::class, 'index'])->name('jobs');
Route::get('/jobs/detail/{id}', [JobsController::class, 'detail'])->name('jobDetail');
Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('applyJob');

Route::prefix('account')->name('account.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('register', [AccountController::class, 'registration'])->name('registration');
        Route::post('process-register', [AccountController::class, 'processRegistration'])->name('processRegistration');
        Route::get('login', [AccountController::class, 'login'])->name('login');
        Route::post('authenticate', [AccountController::class, 'authenticate'])->name('authenticate');
    });

    Route::middleware('auth')->group(function () {
        Route::get('profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('update-profile', [AccountController::class, 'updateProfile'])->name('updateProfile');
        Route::post('update-profile-pic', [AccountController::class, 'updateProfilePic'])->name('updateProfilePic');
        Route::get('logout', [AccountController::class, 'logout'])->name('logout');
        Route::get('create-job', [AccountController::class, 'createJob'])->name('createJob');
        Route::post('save-job', [AccountController::class, 'saveJob'])->name('saveJob');
        Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('myJobs');
        Route::get('/my-jobs/edit/{jobId}', [AccountController::class, 'editJob'])->name('editJob');
        Route::post('/update-job/{jobId}', [AccountController::class, 'updateJob'])->name('updateJob');
        Route::post('/delete-job/{id}', [AccountController::class, 'deleteJob'])->name('deleteJob');
        Route::get('/my-job-applications', [AccountController::class, 'myJobApplications'])->name('myJobApplications');
        Route::post('/remove-job-application', [AccountController::class, 'removeJobs'])->name('removeJob');

        // Video 20 & 21: Saved Jobs
        Route::post('/save-job-post', [AccountController::class, 'bookmarkJob'])->name('saveJobPost');
        Route::get('/saved-jobs', [AccountController::class, 'savedJobs'])->name('savedJobs');
        Route::post('/remove-saved-job', [AccountController::class, 'removeSavedJob'])->name('removeSavedJob');

        // Video 23: Change Password
        Route::get('/change-password', [AccountController::class, 'changePassword'])->name('changePassword');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('updatePassword');
    });
});

// Video 25, 26, 27: Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'isAdmin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/{id}/delete', [UserController::class, 'destroy'])->name('users.delete');

    // Jobs
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs');
    Route::get('/jobs/edit/{id}', [JobController::class, 'edit'])->name('jobs.edit');
    Route::post('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::post('/jobs/delete/{id}', [JobController::class, 'destroy'])->name('jobs.delete');

    // Job Applications
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('jobApplications');
    Route::post('/job-applications/delete/{id}', [JobApplicationController::class, 'destroy'])->name('jobApplications.delete');
});
