<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\JobsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/job/{id}', [JobsController::class, 'detail'])->name('jobDetail');

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

    });

});