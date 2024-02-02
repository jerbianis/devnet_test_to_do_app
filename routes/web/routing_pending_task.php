<?php

use App\Http\Controllers\Task\AdminTaskController;
use App\Http\Controllers\Task\EmployeeTaskController;
use Illuminate\Support\Facades\Route;

/***** Admin Routes *****/
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('pending-task',[AdminTaskController::class,'pending'])->name('pending-task.index');
    Route::patch('pending-task/{task}/accept',[AdminTaskController::class,'accept'])->name('pending-task.accept');
    Route::delete('pending-task/{task}/reject',[AdminTaskController::class,'reject'])->name('pending-task.reject');
});

/***** Employee Routes *****/
Route::middleware('employee')->prefix('employee')->group(function () {
    Route::delete('pending-task/{task}/cancel',[EmployeeTaskController::class,'cancelRequest'])->name('employee.pending-task.destroy');
    Route::get('pending-task',[EmployeeTaskController::class,'pending'])->name('employee.pending-task.index');
});
