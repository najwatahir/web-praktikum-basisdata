<?php

namespace App\Services;

class GeminiService
{
    public function getFeedback(string $soal, string $userQuery, string $errorMessage = ''): string
    {
        return 'Coba periksa kembali query kamu ya.';
    }
}