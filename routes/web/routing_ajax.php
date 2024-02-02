<?php

use App\Http\Controllers\Project\AdminProjectController;
use App\Http\Controllers\Project\EmployeeProjectController;
use App\Http\Controllers\Task\AdminTaskController;
use Illuminate\Support\Facades\Route;


/***** Admin Routes *****/
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('get-projects', [AdminProjectController::class,'getProjects']);
    Route::get('get-projects-with-id', [AdminProjectController::class,'getProjectsWithId']);
Route::get('get-employees-with-email', [AdminTaskController::class,'getEmployeesWithEmail']);
});
/***** Employee Routes *****/
Route::middleware('employee')->prefix('employee')->group(function () {
Route::get('get-projects', [EmployeeProjectController::class,'getProjects']);
Route::get('get-projects-with-id', [EmployeeProjectController::class,'getProjectsWithId']);
});
