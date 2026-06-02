<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('hasil_perhitungans', function (Blueprint $table) {
            $table->json('nilai_utility')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hasil_perhitungans', function (Blueprint $table) {
            $table->decimal('nilai_utility', 10, 4)->nullable()->change();
        });
    }
};
