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
    Schema::create('test_cases', function (Blueprint $table) {
        $table->id();
        $table->foreignId('question_id')->constrained()->cascadeOnDelete();
        $table->string('nama_test_case'); // misal: "Normal Case", "Edge Case"
        $table->text('schema_sql');       // INSERT data yang berbeda-beda
        $table->json('expected_output');  // Kunci jawaban khusus untuk dataset ini
        $table->integer('bobot_poin');    // Misal: 20, 30, 50 (Total harus 100)
        $table->boolean('is_hidden')->default(true); // Disembunyikan dari UI mahasiswa
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
