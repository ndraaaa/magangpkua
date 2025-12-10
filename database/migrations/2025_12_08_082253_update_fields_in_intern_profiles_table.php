<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            // Data Diri Baru
            $table->string('nik', 16)->after('nama_lengkap')->nullable();
            $table->string('nim')->after('nik')->nullable();
            $table->text('alamat')->after('nim')->nullable();

            // Institusi & Akademik
            // Kita rename 'asal_sekolah' jadi 'institusi' agar sesuai request
            $table->renameColumn('asal_sekolah', 'institusi');

            $table->string('semester')->after('jurusan')->nullable();
            $table->string('stase')->after('semester')->nullable(); // Bagian/Stase Magang
            $table->date('tanggal_mulai')->after('stase')->nullable();
            $table->date('tanggal_berakhir')->after('tanggal_mulai')->nullable();
            $table->string('pembimbing_akademik')->after('tanggal_berakhir')->nullable(); // Nama & Gelar

            // File & Foto
            $table->string('pas_foto_path')->after('status')->nullable();

            // Dokumen Tambahan (Path)
            // cv_path & transkrip_path sudah ada sebelumnya
            $table->string('doc_surat_lamaran_path')->nullable();
            $table->string('doc_ijazah_path')->nullable();
            $table->string('doc_kk_path')->nullable();
            $table->string('doc_surat_ijin_path')->nullable(); // Yg ada templatenya
        });
    }

    public function down(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            // Rollback (Hapus kolom jika migrate:rollback)
            $table->dropColumn([
                'nik',
                'nim',
                'alamat',
                'semester',
                'stase',
                'tanggal_mulai',
                'tanggal_berakhir',
                'pembimbing_akademik',
                'pas_foto_path',
                'doc_surat_lamaran_path',
                'doc_ijazah_path',
                'doc_kk_path',
                'doc_surat_ijin_path'
            ]);
            $table->renameColumn('institusi', 'asal_sekolah');
        });
    }
};