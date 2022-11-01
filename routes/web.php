<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebControllers\LoginController;
use App\Http\Controllers\WebControllers\HomeController;
use App\Http\Controllers\WebControllers\AssignmentController;
use App\Http\Controllers\WebControllers\TeacherController;
use App\Http\Controllers\WebControllers\SchoolController;
use App\Http\Controllers\WebControllers\FinanceController;
use App\Http\Controllers\WebControllers\ManagementController;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/cache-clear', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');

    return Artisan::output();
});

// Route::get('/', function () {
//     return view('welcome');
// });
// Auth::routes();
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LoginController::class, 'login']);
Route::post('/processLogin', [LoginController::class, 'processLogin']);
Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/dashboard', [HomeController::class, 'dashboard']);

Route::get('/assignments', [AssignmentController::class, 'assignments']);

Route::get('/teachers', [TeacherController::class, 'teachers']);

Route::get('/schools', [SchoolController::class, 'schools']);

Route::get('/finance', [FinanceController::class, 'finance']);

Route::get('/management', [ManagementController::class, 'management']);
