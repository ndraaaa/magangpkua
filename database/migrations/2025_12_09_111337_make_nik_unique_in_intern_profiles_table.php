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
        Schema::table('intern_profiles', function (Blueprint $table) {
            // Menambahkan index UNIQUE ke kolom nik
            $table->unique('nik');
        });
    }

    public function down(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            // Menghapus index UNIQUE jika di-rollback
            $table->dropUnique(['nik']);
        });
    }
};
