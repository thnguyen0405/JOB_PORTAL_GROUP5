<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
use App\Http\Controllers\AccountController;

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
    });

    
});


