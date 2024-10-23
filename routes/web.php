<?php

use App\Http\Controllers\DashboardalumniController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\TambahDataPerusahaanController;
use App\Http\Controllers\DatalokerController;
use App\Http\Controllers\DetaillokerController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LamaranPerusahaanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfilePerusahaanController;
use App\Http\Controllers\WilayahController;

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
Route::post('/upload-file', [ImportController::class, 'uploadFile'])->name('upload.excel');
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
Route::post('/upload-image', [TambahDataPerusahaanController::class, 'uploadImage'])->name('upload.image');
Route::post('/upload-excel', [TambahDataPerusahaanController::class, 'uploadFilePerusahaan'])->name('upload.file');
Route::post('/file-excel', [TambahDataPerusahaanController::class, 'importperusahaan'])->name('importdata.perusahaan');

// Route for Akun Pengguna
Route::get('/akunpengguna', [App\Http\Controllers\AkunpenggunaController::class, 'index'])->name('akunpengguna');
Route::put('/akunpengguna/{id}/password', [App\Http\Controllers\AkunpenggunaController::class, 'updatePassword'])->name('updatePassword');
Route::get('/tambahadmin', [App\Http\Controllers\TambahAdminController::class, 'index'])->name('tambahadmin');
Route::get('/admin/add', [App\Http\Controllers\TambahAdminController::class, 'create'])->name('admin.create');
Route::post('/admin/add', [App\Http\Controllers\TambahAdminController::class, 'store'])->name('admin.store');
Route::post('/upload-foto', [App\Http\Controllers\TambahAdminController::class, 'uploadFoto'])->name('upload.foto');
// Rute for Loker in Admin
Route::get('/lokeradmin', [App\Http\Controllers\AjuanlokerController::class, 'index'])->name('lokeradmin');
Route::put('/loker/{id_lowongan_pekerjaan}/update-status', [App\Http\Controllers\AjuanlokerController::class, 'updateStatus'])->name('update.status');
// Route for Lacak ALumni
Route::get('/kegiatan', [App\Http\Controllers\KegiatanController::class, 'index'])->name('kegiatan');
// Route Profile Admin
Route::get('/profileadmin', [App\Http\Controllers\ProfileAdminController::class, 'index'])->name('profileadmin');
Route::put('/profileadmin/{nip}', [App\Http\Controllers\ProfileAdminController::class, 'update'])->name('profileadmin.update');
Route::post('/profile/{nip}/update-photo', [App\Http\Controllers\ProfileAdminController::class, 'adminupdatePhoto'])->name('profileadmin.updatePhoto');


// Route for Dashboard Perusahaan
Route::get('/dashboardperusahaan', [App\Http\Controllers\DashboardperusahaanController::class, 'index'])->name('dashboardperusahaan');
// Route for Data Loker in Perusahaan
Route::get('/dataloker', [DatalokerController::class, 'index'])->name('dataloker');
Route::get('/lowongan/{id_lowongan_pekerjaan}', [DatalokerController::class, 'show'])->name('lowongan.show');
Route::post('/lowongan/store', [DatalokerController::class, 'store'])->name('lowongan.store');
Route::get('/lowongan', [DatalokerController::class, 'index'])->name('lowongan.index');
Route::put('/lowongan/{id_lowongan_pekerjaan}', [DatalokerController::class, 'update'])->name('lowongan.update');

Route::get('/lamaran', [LamaranPerusahaanController::class, 'index'])->name('lamaran');
Route::get('/arsiplamaran', [LamaranPerusahaanController::class, 'arsip'])->name('arsiplamaran');
Route::put('/updatestatus/{id}', [LamaranPerusahaanController::class, 'updateStatus'])->name('updatestatus');

Route::get('/profileperusahaan', [ProfilePerusahaanController::class, 'index'])->name('profileperusahaan');
Route::put('/profileperusahaan/{id_data_perusahaan}', [ProfilePerusahaanController::class, 'update'])->name('profileperusahaan.update');
Route::post('/profile/{id_data_perusahaan}/update-photo', [ProfilePerusahaanController::class, 'perusahaanupdatePhoto'])->name('profileperusahaan.updatePhoto');





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
Route::post('/upload-temp', [DashboardalumniController::class, 'uploadTemp'])->name('upload.temp');


//Route for Lamaran Saya
Route::get('/lamaransaya', [App\Http\Controllers\LamaranSayaController::class, 'index'])->name('lamaransaya');
//Route for Detail Job
Route::get('/detailloker/{id_lowongan_pekerjaan}', [DetailLokerController::class, 'show'])->name('detailloker');
//Route for Profile
Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->middleware('auth')->name('profile');
Route::post('/update-about', [App\Http\Controllers\ProfileController::class, 'updateAbout'])->name('update.about');
Route::put('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

Route::middleware(['auth'])->group(function () {
    Route::post('/store-pendidikan-formal', [App\Http\Controllers\ProfileController::class, 'storePendidikanFormal'])->name('store.pendidikan.formal');
    Route::put('/update-pendidikan-formal/{id}', [App\Http\Controllers\ProfileController::class, 'updatePendidikanFormal'])->name('update.pendidikan.formal');
    Route::delete('/delete-pendidikan-formal/{id}', [ProfileController::class, 'deletePendidikanFormal']);
    Route::get('/get-pendidikan-formal/{id}', [App\Http\Controllers\ProfileController::class, 'getPendidikanFormal'])->name('get.pendidikan.formal');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/store-pendidikan-nonformal', [App\Http\Controllers\ProfileController::class, 'storePendidikanNonFormal'])->name('store.pendidikan.nonformal');
    Route::put('/update-pendidikan-nonformal/{id}', [App\Http\Controllers\ProfileController::class, 'updatePendidikanNonFormal'])->name('update.pendidikan.nonformal');
    Route::delete('/delete-pendidikan-nonformal/{id}', [App\Http\Controllers\ProfileController::class, 'deletePendidikanNonFormal'])->name('delete.pendidikan.nonformal');
    Route::get('/get-pendidikan-nonformal/{id}', [App\Http\Controllers\ProfileController::class, 'getPendidikanNonFormal'])->name('get.pendidikan.nonformal');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/store-skill', [App\Http\Controllers\ProfileController::class, 'storeSkill'])->name('store.skill');
    Route::put('/update-skill/{id}', [App\Http\Controllers\ProfileController::class, 'updateSkill'])->name('update.skill');
    Route::delete('/delete-skill/{id}', [App\Http\Controllers\ProfileController::class, 'deleteSkill'])->name('delete.skill');
    Route::get('/get-skill/{id}', [App\Http\Controllers\ProfileController::class, 'getSkill'])->name('get.skill');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/store-pengalaman-kerja', [App\Http\Controllers\ProfileController::class, 'storePengalamanKerja'])->name('store.pengalaman.kerja');
    Route::put('/update-pengalaman-kerja/{id}', [App\Http\Controllers\ProfileController::class, 'updatePengalamanKerja'])->name('update.pengalaman.kerja');
    Route::delete('/delete-pengalaman-kerja/{id}', [App\Http\Controllers\ProfileController::class, 'deletePengalamanKerja'])->name('delete.pengalaman.kerja');
    Route::get('/get-pengalaman-kerja/{id}', [App\Http\Controllers\ProfileController::class, 'getPengalamanKerja'])->name('get.pengalaman.kerja');

    Route::get('/profile/{nik}', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/{nik}/update-photo', [ProfileController::class, 'updatePhoto'])->name('profile.updatePhoto');
    Route::get('/alumni/{nik}/export-profile', [ProfileController::class, 'exportProfile'])->name('alumni.exportProfile');

});


Route::post('/update-kegiatan-sekarang', [App\Http\Controllers\KegiatanController::class, 'updateKegiatan'])->name('updateKegiatanSekarang');

Route::get('/get-provinces', [WilayahController::class, 'getProvinces']);
Route::get('/get-cities/{provinceId}', [WilayahController::class, 'getCities']);
