<?php

use App\Jobs\SendEmailJob;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProjectController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'user_log'])->group(function(){
    Route::get('/home', [HomeController::class, 'index']);
    Route::resource('projects', '\App\Http\Controllers\Admin\ProjectController');
    Route::get('project-create', [ProjectController::class, 'create'])->name('project-create');
    Route::get('get/progects', [ProjectController::class, 'getData'])->name('get/progects');
    Route::post('upload-store', [ProjectController::class, 'uploadFiles'])->name('upload.store');
    Route::post('restore-all-project', [ProjectController::class, 'restoreDeleteData'])->name('restore-all-project');

    Route::get('recycle-date', [ProjectController::class, 'getDeletedData'])->name('recycle-data');
});