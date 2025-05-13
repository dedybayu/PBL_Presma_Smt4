<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\KelasController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('custom.login');

Route::middleware(['auth:mahasiswa,dosen,admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
        Route::post('/list', [MahasiswaController::class, 'list']);
        Route::get('/{mahasiswa}/show', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
        Route::get('/create', [MahasiswaController::class, 'create'])->name('mahasiswa.create');
        Route::post('/', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
        Route::get('/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
        Route::put('/{mahasiswa}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
        Route::get('/{mahasiswa}/confirm-delete', [MahasiswaController::class, 'confirmDelete'])->name('mahasiswa.confirm-delete');
        Route::delete('/{mahasiswa}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
    });
    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::post('/list', [KelasController::class, 'list']);
        Route::get('/{kelas}/show', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::put('/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });
    Route::prefix('dosen')->group(function () {
        Route::get('/', [DosenController::class, 'index'])->name('dosen.index');
        Route::post('/list', [DosenController::class, 'list']);
        Route::get('/create', [DosenController::class, 'create'])->name('dosen.create');
        Route::post('/', [DosenController::class, 'store'])->name('dosen.store');
        Route::get('/{id}/edit', [DosenController::class, 'edit'])->name('dosen.edit');
        Route::put('/{id}', [DosenController::class, 'update'])->name('dosen.update');
        Route::delete('/{id}', [DosenController::class, 'destroy'])->name('dosen.destroy');
    });
});




// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// });


Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');