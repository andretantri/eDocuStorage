<?php

use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\AdminController as AdminController;
use App\Http\Controllers\RegisterController as RegisterController;

use App\Http\Controllers\Admin\KriteriaController as KriteriaAdmin;
use App\Http\Controllers\Admin\FolderController as FolderAdmin;

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
    Route::get('/folder/kriteria-tambah/{id}', [FolderAdmin::class, 'pertanyaan'])->name('admin.folder.list');
    Route::post('/folder/kriteria-store/{id}', [FolderAdmin::class, 'store'])->name('admin.folder.store');
});
