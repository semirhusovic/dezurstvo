<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/',[\App\Http\Controllers\Auth\LoginController::class,'login'])->middleware('auth');

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home',[App\Http\Controllers\CleaningScheduleController::class,'index'])->name('raspored')->middleware('auth');
//Route::get('/kreiraj',[App\Http\Controllers\CleaningScheduleController::class,'populateData'])->name('kreiraj');
Route::get('schedule/export/', [App\Http\Controllers\CleaningScheduleController::class, 'export'])->name('schedule-report')->middleware('auth');
Route::get('/my-schedule',[App\Http\Controllers\CleaningScheduleController::class,'userSchedule'])->name('my-schedule')->middleware('auth');
Route::get('/history',[App\Http\Controllers\CleaningScheduleController::class,'scheduleHistory'])->name('history')->middleware('auth');
Route::resource('/users',App\Http\Controllers\UserController::class)->middleware('auth');
Route::post('update-task',[App\Http\Controllers\CleaningScheduleController::class, 'updateTask']);


