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
        Schema::create('hasil_perhitungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained()->onDelete('cascade');
            $table->foreignId('alternatif_id')->constrained()->onDelete('cascade');
            $table->decimal('nilai_utility', 10, 4);
            $table->decimal('nilai_akhir', 10, 4);
            $table->integer('ranking');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_perhitungans');
    }
};
