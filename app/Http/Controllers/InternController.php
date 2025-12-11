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
        if (Auth::user()->internProfile) {
            return redirect()->route('dashboard')->with('status', 'Anda sudah mengisi biodata!');
        }

        return view('interns.create');
    }

    public function store(Request $request)
    {
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

            'pas_foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'cv' => 'required|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'surat_lamaran' => 'required|mimes:pdf|max:2048',
            'ijazah' => 'nullable|mimes:pdf|max:2048',
            'kk' => 'required|mimes:pdf,jpg,jpeg|max:2048',
            'surat_ijin' => 'required|mimes:pdf|max:2048',
        ]);

        $uploadFile = function ($file, $folder) {
            return $file ? $file->store($folder, 'public') : null;
        };

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
        $profile = Auth::user()->internProfile;

        if (!$profile) {
            return redirect()->route('biodata.create')->with('error', 'Silakan isi biodata terlebih dahulu.');
        }

        return view('interns.show', compact('profile'));
    }

    public function edit()
    {
        $profile = Auth::user()->internProfile;

        if (!$profile) {
            return redirect()->route('biodata.create');
        }

        return view('interns.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $profile = Auth::user()->internProfile;

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
            'pas_foto' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf|max:2048',
            'transkrip' => 'nullable|mimes:pdf|max:2048',
            'surat_lamaran' => 'nullable|mimes:pdf|max:2048',
            'ijazah' => 'nullable|mimes:pdf|max:2048',
            'kk' => 'nullable|mimes:pdf,jpg,jpeg|max:2048',
            'surat_ijin' => 'nullable|mimes:pdf|max:2048',
        ]);

        $handleFileUpload = function ($inputName, $folder, $oldPath) use ($request) {
            if ($request->hasFile($inputName)) {
                if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
                return $request->file($inputName)->store($folder, 'public');
            }
            return $oldPath;
        };

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

            // Data File
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
