<?php

// Import model dan controller yang dibutuhkan
use App\Models\Report;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web".
|
*/

// == 1. Rute Publik / Landing Page ==
Route::get('/', function () {
    // Ambil 3 laporan terbaru dengan status 'diterima' atau 'selesai'
    $news = Report::whereIn('status', ['diterima', 'selesai'])
                  ->latest()
                  ->take(3)
                  ->get();
                  
    return view('welcome', compact('news'));
});

// == 2. Rute User yang Sudah Login (Dashboard & Laporan) ==
// Rute ini memerlukan user untuk login
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard (Menampilkan statistik, tombol lapor)
    Route::get('/dashboard', [UserReportController::class, 'index'])->name('dashboard');

    // Halaman List "Laporan Saya"
    Route::get('/my-reports', [UserReportController::class, 'myReports'])->name('user.reports.index');
    
    // Halaman Form "Buat Laporan Baru"
    Route::get('/report/create', [UserReportController::class, 'create'])->name('user.reports.create');
    
    // Logika untuk Menyimpan Laporan Baru
    Route::post('/report', [UserReportController::class, 'store'])->name('user.reports.store');
    
    // Rute TAMPILKAN (Lihat)
    Route::get('/report/{report}', [UserReportController::class, 'show'])->name('user.reports.show');
    
    // Rute EDIT (Form Edit)
    Route::get('/report/{report}/edit', [UserReportController::class, 'edit'])->name('user.reports.edit');
    
    // Rute UPDATE (Proses Simpan Edit)
    Route::patch('/report/{report}', [UserReportController::class, 'update'])->name('user.reports.update');
    
    // Rute HAPUS
    Route::delete('/report/{report}', [UserReportController::class, 'destroy'])->name('user.reports.destroy');

    // Rute Export PDF
    Route::get('/reports/export', [UserReportController::class, 'exportPDF'])->name('user.reports.export');

});

// == 3. Rute Profil Bawaan Breeze ==
// Rute ini juga memerlukan login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    
    // [BARU] Rute Update Avatar
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// == 4. Rute Autentikasi (Login, Register, Dll) ==
require __DIR__.'/auth.php';