<?php

use App\Http\Controllers\Project\AdminProjectController;
use Illuminate\Support\Facades\Route;


Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('project', AdminProjectController::class)->except(['create','show']);
});
