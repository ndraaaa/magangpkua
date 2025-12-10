<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('intern_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_lengkap');
            $table->string('nomor_hp');
            $table->string('asal_sekolah'); // Kampus/SMK
            $table->string('jurusan');
            $table->string('cv_path')->nullable();
            $table->string('transkrip_path')->nullable();
            $table->timestamps();
        });
    }
};
