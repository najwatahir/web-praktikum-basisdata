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
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->string('judul', 200);
        $table->text('deskripsi');
        $table->text('schema_sql');          // CREATE TABLE + INSERT data soal
        $table->text('expected_sql');        // query model jawaban admin
        $table->json('expected_output');     // hasil expected_sql (auto-generate)
        $table->integer('poin')->default(100);
        $table->integer('urutan')->default(0);
        $table->boolean('order_matters')->default(false); // kalau soal butuh ORDER BY spesifik
        $table->boolean('aktif')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
