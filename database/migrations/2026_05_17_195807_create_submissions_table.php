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
    Schema::create('submissions', function (Blueprint $table) {
        $table->id();
        $table->string('nim', 20);
        $table->foreignId('question_id')->constrained()->cascadeOnDelete();
        $table->text('query');               // query yang dikirim mahasiswa
        $table->boolean('is_correct')->default(false);
        $table->integer('score')->default(0);
        $table->integer('attempt')->default(1); // percobaan ke berapa
        $table->text('feedback')->nullable();   // feedback dari gemini kalau salah
        $table->timestamps();

        $table->foreign('nim')->references('nim')->on('participants')->cascadeOnDelete();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
