<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InternProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',

        // Data Diri
        'nama_lengkap',
        'nik',
        'nomor_hp',
        'nim',
        'alamat',
        'pas_foto_path',

        // Akademik
        'institusi',
        'jurusan',
        'semester',
        'stase',
        'tanggal_mulai',
        'tanggal_berakhir',
        'pembimbing_akademik',

        // Dokumen
        'cv_path',
        'transkrip_path', // Ini field lama (sesuaikan nama di db jika beda)
        'doc_surat_lamaran_path',
        'doc_ijazah_path',
        'doc_kk_path',
        'doc_surat_ijin_path',
    ];

    // Relasi balik ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
