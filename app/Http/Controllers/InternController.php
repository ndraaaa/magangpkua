<?php

namespace App\Http\Controllers;

use App\Models\InternProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InternController extends Controller
{
    public function create()
    {
        // Cek jika user sudah pernah isi biodata, alihkan ke halaman lain (opsional)
        if (Auth::user()->internProfile) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah mengisi biodata!');
        }

        return view('interns.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:intern_profiles,nik',
            'nomor_hp' => 'required|string',
            'nim' => 'required|string',
            'alamat' => 'required|string',
            'institusi' => 'required|string',
            'jurusan' => 'required|string',
            'semester' => 'required|string',
            'stase' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'pembimbing_akademik' => 'required|string',

            // Validasi File (Max 2MB per file)
            'pas_foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'cv' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'surat_lamaran' => 'required|mimes:pdf|max:2048',
            'ijazah' => 'nullable|mimes:pdf|max:2048',
            'kk' => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'surat_ijin' => 'required|mimes:pdf|max:2048',
        ]);

        // 2. Fungsi Helper untuk Upload (Biar kodenya rapi)
        $uploadFile = function ($file, $folder) {
            return $file ? $file->store($folder, 'public') : null;
        };

        // 3. Simpan ke Database
        InternProfile::create([
            'user_id' => Auth::id(),
            'status' => 'pending', // Default

            // Data Text
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
            'nim' => $request->nim,
            'alamat' => $request->alamat,
            'institusi' => $request->institusi,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'stase' => $request->stase,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'pembimbing_akademik' => $request->pembimbing_akademik,

            // Data File (Simpan Path)
            'pas_foto_path' => $uploadFile($request->file('pas_foto'), 'fotos'),
            'cv_path' => $uploadFile($request->file('cv'), 'dokumen_magang'),
            'transkrip_path' => $uploadFile($request->file('transkrip'), 'dokumen_magang'),
            'doc_surat_lamaran_path' => $uploadFile($request->file('surat_lamaran'), 'dokumen_magang'),
            'doc_ijazah_path' => $uploadFile($request->file('ijazah'), 'dokumen_magang'),
            'doc_kk_path' => $uploadFile($request->file('kk'), 'dokumen_magang'),
            'doc_surat_ijin_path' => $uploadFile($request->file('surat_ijin'), 'dokumen_magang'),
        ]);

        return redirect()->route('biodata.show')->with('success', 'Biodata lengkap berhasil disimpan!');
    }

    public function show()
    {
        // Ambil data profile dari user yang sedang login
        $profile = Auth::user()->internProfile;

        // Jika belum isi biodata, lempar ke halaman isi biodata
        if (!$profile) {
            return redirect()->route('biodata.create')->with('error', 'Silakan isi biodata terlebih dahulu.');
        }

        return view('interns.show', compact('profile'));
    }

    // 1. TAMPILKAN FORM EDIT
    public function edit()
    {
        $profile = Auth::user()->internProfile;

        if (!$profile) {
            return redirect()->route('biodata.create');
        }

        return view('interns.edit', compact('profile'));
    }

    // 2. PROSES UPDATE DATA
    public function update(Request $request)
    {
        $profile = Auth::user()->internProfile;

        // Validasi (Perhatikan: File jadi NULLABLE / tidak wajib diisi ulang)
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:intern_profiles,nik,' . $profile->id,
            'nomor_hp' => 'required|string',
            'nim' => 'required|string',
            'alamat' => 'required|string',
            'institusi' => 'required|string',
            'jurusan' => 'required|string',
            'semester' => 'required|string',
            'stase' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'pembimbing_akademik' => 'required|string',

            // File validasinya 'nullable' (boleh kosong jika tidak mau ganti file)
            'pas_foto' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'surat_lamaran' => 'nullable|mimes:pdf|max:2048',
            'ijazah' => 'nullable|mimes:pdf|max:2048',
            'kk' => 'nullable|mimes:pdf,jpg,jpeg|max:2048',
            'surat_ijin' => 'nullable|mimes:pdf|max:2048',
        ]);

        // Helper Function untuk Cek File Lama -> Hapus -> Upload Baru
        $handleFileUpload = function ($inputName, $folder, $oldPath) use ($request) {
            if ($request->hasFile($inputName)) {
                // Hapus file lama jika ada
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                // Upload file baru
                return $request->file($inputName)->store($folder, 'public');
            }
            // Jika tidak upload baru, kembalikan path lama
            return $oldPath;
        };

        // Update Database
        $profile->update([
            // Data Text
            'nama_lengkap' => $request->nama_lengkap,
            'nik' => $request->nik,
            'nomor_hp' => $request->nomor_hp,
            'nim' => $request->nim,
            'alamat' => $request->alamat,
            'institusi' => $request->institusi,
            'jurusan' => $request->jurusan,
            'semester' => $request->semester,
            'stase' => $request->stase,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'pembimbing_akademik' => $request->pembimbing_akademik,

            // Data File (Pakai helper di atas)
            'pas_foto_path' => $handleFileUpload('pas_foto', 'fotos', $profile->pas_foto_path),
            'cv_path' => $handleFileUpload('cv', 'dokumen_magang', $profile->cv_path),
            'transkrip_path' => $handleFileUpload('transkrip', 'dokumen_magang', $profile->transkrip_path),
            'doc_surat_lamaran_path' => $handleFileUpload('surat_lamaran', 'dokumen_magang', $profile->doc_surat_lamaran_path),
            'doc_ijazah_path' => $handleFileUpload('ijazah', 'dokumen_magang', $profile->doc_ijazah_path),
            'doc_kk_path' => $handleFileUpload('kk', 'dokumen_magang', $profile->doc_kk_path),
            'doc_surat_ijin_path' => $handleFileUpload('surat_ijin', 'dokumen_magang', $profile->doc_surat_ijin_path),
        ]);

        return redirect()->route('biodata.show')->with('success', 'Biodata berhasil diperbarui!');
    }
}
