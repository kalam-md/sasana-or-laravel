<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Jadwal\JadwalController;
use App\Http\Controllers\Lapangan\LapanganController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Pelanggan\PelangganController;
use App\Http\Controllers\Profile\ProfileController;
use App\Models\Jadwal;
use App\Models\Lapangan;
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
    return view('welcome', [
        'lapangans' => Lapangan::all()
    ]);
});


Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/profile/{username}', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/profile/{username}/update', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan')->middleware('auth');

Route::resource('/lapangan', LapanganController::class)->parameters([
    'lapangan' => 'lapangan:slug',
])->middleware(['auth', 'role:admin']);

Route::get('/jadwal', [JadwalController::class, 'index'])->middleware(['auth', 'role:admin'])->name('jadwal.index');
Route::post('/update-jadwal-status/{id}', [JadwalController::class, 'updateStatus']);

Route::get('/pemesanan', [OrderController::class, 'index'])->middleware(['auth', 'role:admin,user'])->name('pemesanan.index');
Route::get('/pemesanan/create', [OrderController::class, 'create'])->middleware(['auth', 'role:admin,user'])->name('pemesanan.create');
Route::get('/pemesanan/lapangan/detail/{id}', [OrderController::class, 'getDetail']);
Route::post('/pemesanan', [OrderController::class, 'store'])->name('pemesanan.store');
Route::get('/pemesanan/booked-jadwals', [OrderController::class, 'getBookedJadwals']);
Route::get('/pemesanan/{invoices}', [OrderController::class, 'pemesananDetail'])->middleware(['auth', 'role:admin,user'])->name('pemesanan.detail');
Route::post('/pemesanan/{invoices}/upload-bukti', [OrderController::class, 'uploadBuktiBayar'])->middleware(['auth', 'role:admin,user'])->name('pemesanan.uploadBukti');
Route::post('/pemesanan/verifikasi/{invoices}', [OrderController::class, 'verifikasiPembayaran'])->name('pemesanan.verifikasi');
Route::get('/pemesanan/{invoices}/cetak', [OrderController::class, 'pemesananCetak'])->middleware(['auth', 'role:admin,user'])->name('pemesanan.cetak');
