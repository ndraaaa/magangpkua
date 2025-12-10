<?php

namespace App\Http\Controllers;

use App\Models\InternProfile;
use Illuminate\Http\Request;
use App\Exports\ApplicantsExport;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // 1. Tampilkan Daftar Semua Pelamar
    public function index()
    {
        // Ambil data profile beserta data user-nya (Eager Loading)
        $applicants = InternProfile::with('user')->latest()->get();
        return view('admin.applicants.index', compact('applicants'));
    }

    // 2. Tampilkan Detail Pelamar (Untuk Review)
    public function show($id)
    {
        $profile = InternProfile::with('user')->findOrFail($id);
        return view('admin.applicants.show', compact('profile'));
    }

    // 3. Proses Update Status (Terima/Tolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accepted,rejected,pending'
        ]);

        $profile = InternProfile::findOrFail($id);
        $profile->update(['status' => $request->status]);

        // Kirim pesan notifikasi
        $statusMsg = $request->status == 'accepted' ? 'Diterima' : 'Ditolak';
        return redirect()->route('admin.applicants.show', $id)
            ->with('success', "Status pelamar berhasil diubah menjadi: $statusMsg");
    }

    public function exportExcel()
    {
        return Excel::download(new ApplicantsExport, 'data_pelamar_magang.xlsx');
    }
}
