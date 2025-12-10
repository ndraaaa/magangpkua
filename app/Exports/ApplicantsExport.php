<?php

namespace App\Exports;

use App\Models\InternProfile;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ApplicantsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
     * Mengambil data dari database
     */
    public function collection()
    {
        // Ambil semua data beserta user-nya, urutkan dari yang terbaru
        return InternProfile::with('user')->latest()->get();
    }

    /**
     * Mengatur Judul Header (Baris Pertama Excel)
     */
    public function headings(): array
    {
        return [
            'Tanggal Daftar',
            'Nama Lengkap',
            'Status Lamaran',
            'NIK',
            'NIM',
            'No HP',
            'Institusi',
            'Jurusan',
            'Semester',
            'Stase',
            'Pembimbing Akademik',
            'Tanggal Mulai',
            'Tanggal Berakhir',
            'Link CV',
            'Link Transkrip',
            'Link Surat Lamaran',
            'Link Surat Ijin',
        ];
    }

    /**
     * Mengatur Isi Data per Baris
     */
    public function map($profile): array
    {
        // Helper kecil untuk membuat full URL dokumen
        $getFile = function ($path) {
            return $path ? asset('storage/' . $path) : '-';
        };

        return [
            $profile->created_at->format('d-m-Y'),
            $profile->nama_lengkap,
            strtoupper($profile->status), // PENDING/ACCEPTED/REJECTED
            "'" . $profile->nik, // Tanda kutip agar Excel membacanya sebagai teks (biar angka tidak berubah aneh)
            $profile->nim,
            $profile->nomor_hp,
            $profile->institusi,
            $profile->jurusan,
            $profile->semester,
            $profile->stase,
            $profile->pembimbing_akademik,
            $profile->tanggal_mulai,
            $profile->tanggal_berakhir,

            // Kolom Link Dokumen
            $getFile($profile->cv_path),
            $getFile($profile->transkrip_path),
            $getFile($profile->doc_surat_lamaran_path),
            $getFile($profile->doc_surat_ijin_path),
        ];
    }
}