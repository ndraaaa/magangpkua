<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\AdminController; // <--- PENTING: Controller Admin
use App\Models\InternProfile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;      // <--- PENTING: Untuk Auth::user()

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (LOGIC DINAMIS ADMIN VS USER) ---
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        // DATA UNTUK ADMIN
        $data = [
            'total_pelamar' => InternProfile::count(),
            'pending' => InternProfile::where('status', 'pending')->count(),
            'diterima' => InternProfile::where('status', 'accepted')->count(),
            'ditolak' => InternProfile::where('status', 'rejected')->count(),
            'terbaru' => InternProfile::with('user')->latest()->take(5)->get()
        ];
        return view('dashboard', compact('data'));
    } else {
        // DATA UNTUK PEMAGANG
        $profile = $user->internProfile;
        return view('dashboard', compact('profile'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP KHUSUS ADMIN (Hanya bisa diakses Admin) ---
Route::middleware(['auth', 'role:admin'])->group(function () {

    // List semua pelamar
    Route::get('/admin/applicants', [AdminController::class, 'index'])->name('admin.applicants.index');

    // Detail pelamar & Aksi Review
    Route::get('/admin/applicants/{id}', [AdminController::class, 'show'])->name('admin.applicants.show');

    // Simpan Keputusan (Terima/Tolak)
    Route::patch('/admin/applicants/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.applicants.update_status');
    Route::get('/admin/applicants/export', [AdminController::class, 'exportExcel'])->name('admin.applicants.export');
});


// --- GROUP USER LOGIN (Bisa Admin & User Biasa) ---
Route::middleware('auth')->group(function () {

    // Biodata Magang
    Route::get('/biodata', [InternController::class, 'show'])->name('biodata.show');
    Route::get('/biodata/isi', [InternController::class, 'create'])->name('biodata.create');
    Route::post('/biodata/simpan', [InternController::class, 'store'])->name('biodata.store');
    Route::get('/biodata/edit', [InternController::class, 'edit'])->name('biodata.edit');
    Route::patch('/biodata/update', [InternController::class, 'update'])->name('biodata.update');

    // Profile Bawaan Breeze (Ganti Password, Hapus Akun)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';