<?php

use App\Http\Controllers\Task\AdminTaskController;
use App\Http\Controllers\Task\EmployeeTaskController;
use Illuminate\Support\Facades\Route;

/***** Admin Routes *****/
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::resource('task', AdminTaskController::class)->except(['create', 'show']);
    Route::patch('task/todo/{task}', [AdminTaskController::class, 'toDo'])->name('task.todo');
    Route::patch('task/doing/{task}', [AdminTaskController::class, 'doing'])->name('task.doing');
    Route::patch('task/done/{task}', [AdminTaskController::class, 'done'])->name('task.done');
});

/***** Employee Routes *****/
Route::middleware('employee')->prefix('employee')->group(function () {
    Route::get('task',[EmployeeTaskController::class,'index'])->name('employee.task.index');
    Route::post('task',[EmployeeTaskController::class,'store'])->name('employee.task.store');
    Route::patch('task/{task}/estimate',[EmployeeTaskController::class,'estimate'])->name('employee.task.estimate');
    Route::patch('task/todo/{task}',[EmployeeTaskController::class,'toDo'])->name('employee.task.todo');
    Route::patch('task/doing/{task}',[EmployeeTaskController::class,'doing'])->name('employee.task.doing');
    Route::patch('task/done/{task}',[EmployeeTaskController::class,'done'])->name('employee.task.done');
});
