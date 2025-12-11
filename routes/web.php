<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\AdminController;
use App\Models\InternProfile;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (LOGIC DINAMIS ADMIN VS USER) ---
Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        $data = [
            'total_pelamar' => InternProfile::count(),
            'pending' => InternProfile::where('status', 'pending')->count(),
            'diterima' => InternProfile::where('status', 'accepted')->count(),
            'ditolak' => InternProfile::where('status', 'rejected')->count(),
            'terbaru' => InternProfile::with('user')->latest()->take(5)->get()
        ];
        return view('dashboard', compact('data'));
    } else {
        $profile = $user->internProfile;
        return view('dashboard', compact('profile'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');


// --- GROUP KHUSUS ADMIN (Hanya bisa diakses Admin) ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/applicants', [AdminController::class, 'index'])->name('admin.applicants.index');
    Route::get('/admin/applicants/export', [AdminController::class, 'exportExcel'])->name('admin.applicants.export');
    Route::get('/admin/applicants/{id}', [AdminController::class, 'show'])->name('admin.applicants.show');
    Route::delete('/admin/applicants/{id}', [AdminController::class, 'destroy'])->name('admin.applicants.destroy');
    Route::patch('/admin/applicants/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.applicants.update_status');

    // MANAJEMEN ADMIN
    Route::get('/admin/list', [AdminUserController::class, 'index'])->name('admin.users.index'); // <-- BARU
    Route::get('/admin/create-new', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/create-new', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
});


// --- GROUP USER LOGIN (Bisa Admin & User Biasa) ---
Route::middleware('auth')->group(function () {
    Route::get('/biodata', [InternController::class, 'show'])->name('biodata.show');
    Route::get('/biodata/isi', [InternController::class, 'create'])->name('biodata.create');
    Route::post('/biodata/simpan', [InternController::class, 'store'])->name('biodata.store');
    Route::get('/biodata/edit', [InternController::class, 'edit'])->name('biodata.edit');
    Route::patch('/biodata/update', [InternController::class, 'update'])->name('biodata.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
