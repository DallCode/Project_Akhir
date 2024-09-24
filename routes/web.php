<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login Route
Route::prefix('auth')->group(function () {
    Route::get('login', [App\Http\Controllers\LoginController::class, 'show'])->name('login.form'); // Perbedaan nama
    Route::post('login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.submit'); // Perbedaan nama
    Route::post('logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
});


Route::get('/', function () {
    // return view('dashboardAdmin');
    return view('auth/login');
});


Route::get('/dashboard', [App\Http\Controllers\HalamanController::class, 'index'])->name('dashboard')->middleware('auth');

Auth::routes();

// Dashboard Admin Route
Route::get('/dashboardadmin', [App\Http\Controllers\DashboardadminController::class, 'index'])->name('dashboardadmin');
// Alumni in Admin Route
Route::get('/alumniadmin', [App\Http\Controllers\AlumniadminController::class, 'index'])->name('alumniadmin');

// Route for View Data Perusahaan in Admin
Route::get('/dataperusahaan', [App\Http\Controllers\DataPerusahaanController::class, 'index'])->name('perusahaan.index');