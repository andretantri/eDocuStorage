<?php

use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\AdminController as AdminController;
use App\Http\Controllers\RegisterController as RegisterController;

use App\Http\Controllers\Admin\KriteriaController as KriteriaAdmin;
use App\Http\Controllers\Admin\FolderController as FolderAdmin;
use App\Http\Controllers\Admin\UserManageController as UserManage;
use App\Http\Controllers\Admin\PencarianController as PencarianAdmin;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
})->name('/');

// Route untuk menampilkan halaman register
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
// Route untuk menangani proses register
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Route untuk menampilkan halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route untuk menangani proses login
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route untuk logout

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/kriteria', [KriteriaAdmin::class, 'index'])->name('admin.kriteria');
    Route::get('/kriteria-tambah', [KriteriaAdmin::class, 'create'])->name('admin.kriteria.create');
    Route::get('/get-kriteria', [KriteriaAdmin::class, 'getData'])->name('admin.get.kriteria');
    Route::post('/kriteria-store', [KriteriaAdmin::class, 'store'])->name('admin.kriteria.store');
    Route::get('/kriteria-edit/{id}', [KriteriaAdmin::class, 'edit'])->name('admin.kriteria.edit');
    Route::put('/kriteria-update/{id}', [KriteriaAdmin::class, 'update'])->name('admin.kriteria.update');
    Route::delete('/kriteria-delete/{id}', [KriteriaAdmin::class, 'destroy'])->name('admin.kriteria.delete');

    Route::get('/folder/kriteria/{id}/{folder}', [FolderAdmin::class, 'tabel'])->name('admin.folder.tabel');
    Route::post('/folder/kriteria-store/{id}', [FolderAdmin::class, 'store'])->name('admin.folder.store');
    Route::post('/file/kriteria-store/{id}', [FolderAdmin::class, 'upload'])->name('admin.file.upload');
    Route::get('/file/stream/{id}', [FolderAdmin::class, 'streamFile'])->name('admin.file.stream');
    Route::delete('/folder/delete/{id}', [FolderAdmin::class, 'destroy'])->name('admin.folder.delete');
    Route::delete('/file/delete/{id}', [FolderAdmin::class, 'destroyFile'])->name('admin.file.delete');

    Route::get('/user', [UserManage::class, 'index'])->name('admin.user');
    Route::get('/user-tambah', [UserManage::class, 'create'])->name('admin.user.create');
    Route::get('/get-user', [UserManage::class, 'getData'])->name('admin.get.user');
    Route::post('/user-store', [UserManage::class, 'store'])->name('admin.user.store');
    Route::get('/user-edit/{id}', [UserManage::class, 'edit'])->name('admin.user.edit');
    Route::put('/user-update/{id}', [UserManage::class, 'update'])->name('admin.user.update');
    Route::delete('/user-delete/{id}', [UserManage::class, 'destroy'])->name('admin.user.delete');

    Route::get('/search', [PencarianAdmin::class, 'index'])->name('admin.search');
    Route::get('/pencarian', [PencarianAdmin::class, 'search'])->name('admin.pencarian');
    Route::get('/folder/view/{id}/{folder}', [FolderAdmin::class, 'view'])->name('admin.folder.view');
});
