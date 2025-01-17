<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\PublisherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/job-offers', [JobController::class, 'store'])->name('job.store');
Route::get('/job-board', [JobController::class, 'index'])->name('job.index');
Route::get('/job-create', [JobController::class, 'create'])->name('job.create');


Route::get('/publisher/approve/{id}', [PublisherController::class, 'approve'])
    ->name('publisher.approve')
    ->middleware('signed');

Route::get('/publisher/spam/{id}', [PublisherController::class, 'markAsSpam'])
    ->name('publisher.spam')
    ->middleware('signed');
