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
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliah', 'id');
            $table->foreignId('dosen_id')->constrained('users', 'id');
            $table->foreignId('program_studi_id')->constrained('program_studi', 'id');
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademik', 'id');
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('type', ['offline', 'online']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};
