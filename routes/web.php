<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TambahDataPerusahaanController;
use App\Http\Controllers\DatalokerController;
use App\Http\Controllers\DetaillokerController;
use App\Http\Controllers\FileController;

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
/// Route untuk menampilkan form upload
Route::get('/importdata', [ImportController::class, 'index'])->name('importdata');
Route::post('/upload-file', [ImportController::class, 'uploadFile'])->name('upload.file');
Route::post('/import', [ImportController::class, 'import'])->name('import');
Route::get('/download-excel', [FileController::class, 'downloadTemplate'])->name('download.template');

// Alumni in Admin Route
Route::get('/alumniadmin', [App\Http\Controllers\AlumniadminController::class, 'index'])->name('alumniadmin');
Route::put('/alumni/{nik}', [App\Http\Controllers\AlumniadminController::class, 'update'])->name('alumni.update');

// Route for View Data Perusahaan in Admin
Route::get('/dataperusahaan', [App\Http\Controllers\DataPerusahaanController::class, 'index'])->name('perusahaan.index');
Route::put('/perusahaan/update/{id_data_perusahaan}', [App\Http\Controllers\DataPerusahaanController::class, 'update'])->name('perusahaan.update');
// Route for Tambah Data Perusahaan
Route::get('/tambahdataperusahaan', [TambahDataPerusahaanController::class, 'index'])->name('tambahdataperusahaan.index');
Route::post('/tambahdataperusahaan', [TambahDataPerusahaanController::class, 'store'])->name('tambahdataperusahaan.store');
// Route for Akun Pengguna
Route::get('/akunpengguna', [App\Http\Controllers\AkunpenggunaController::class, 'index'])->name('akunpengguna');
// Rute for Loker in Admin
Route::get('/lokeradmin', [App\Http\Controllers\AjuanlokerController::class, 'index'])->name('lokeradmin');
Route::put('/loker/{id_lowongan_pekerjaan}/update-status', [App\Http\Controllers\AjuanlokerController::class, 'updateStatus'])->name('update.status');


// Route for Dashboard Perusahaan
Route::get('/dashboardperusahaan', [App\Http\Controllers\DashboardperusahaanController::class, 'index'])->name('dashboardperusahaan');
// Route for Data Loker in Perusahaan
Route::get('/dataloker', [DatalokerController::class, 'index'])->name('dataloker');
Route::get('/lowongan/{id_lowongan_pekerjaan}', [DatalokerController::class, 'show'])->name('lowongan.show');
Route::post('/lowongan/store', [DatalokerController::class, 'store'])->name('lowongan.store');
Route::get('/lowongan', [DatalokerController::class, 'index'])->name('lowongan.index');
Route::put('/lowongan/{id_lowongan_pekerjaan}', [DatalokerController::class, 'update'])->name('lowongan.update');


// Route for Alumni Role
// Route for Dashboard Alumni
Route::get('/dashboardalumni', [App\Http\Controllers\DashboardalumniController::class, 'index'])->name('dashboardalumni');
// // Route untuk halaman detail pekerjaan
// Route::get('/job-detail/{id}', [App\Http\Controllers\JobDetailController::class, 'show'])->name('job.detail');
// web.php

// Route for search Job
Route::get('/search', [App\Http\Controllers\DashboardalumniController::class, 'index'])->name('job.search');
//Route for Lamar
Route::post('/lamar', [App\Http\Controllers\DashboardalumniController::class, 'store'])->name('lamar.store');
//Route for Lamaran Saya
Route::get('/lamaransaya', [App\Http\Controllers\LamaranSayaController::class, 'index'])->name('lamaransaya');
//Route for Detail Job
Route::get('/detailloker/{id_lowongan_pekerjaan}', [DetailLokerController::class, 'show'])->name('detailloker');
//Route for Profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');


