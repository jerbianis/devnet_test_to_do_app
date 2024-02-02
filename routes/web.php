<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->prefix('dashboard')->group(function () {

    Route::get('/', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    include('web/routing_project.php');
    include('web/routing_task.php');
    include('web/routing_pending_task.php');
    include('web/routing_ajax.php');

});


