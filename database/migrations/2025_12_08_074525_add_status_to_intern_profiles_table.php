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
            // Kita pakai ENUM agar isinya pasti: pending, accepted, atau rejected
            // Defaultnya 'pending' (Menunggu)
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->after('jurusan');
        });
    }

    public function down(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
