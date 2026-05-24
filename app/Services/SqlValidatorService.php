<?php

namespace App\Services;

class SqlValidatorService
{
    // Cek benar/salah total
    public function validate(array $userResult, array $expectedResult, bool $orderMatters = false): bool
    {
        return $this->score($userResult, $expectedResult, $orderMatters) === 100;
    }

    // Hitung skor 0-100
    public function score(array $userResult, array $expectedResult, bool $orderMatters = false): int
    {
        if (empty($expectedResult)) return 0;
        if (empty($userResult)) return 0;

        // Cek kolom dulu — kalau kolom beda, skor 0
        $expectedKeys = array_keys((array) $expectedResult[0]);
        $userKeys     = array_keys((array) $userResult[0]);

        $expectedKeys = array_map('strtolower', $expectedKeys);
        $userKeys     = array_map('strtolower', $userKeys);

        sort($expectedKeys);
        sort($userKeys);

        if ($expectedKeys !== $userKeys) return 0;

        // Normalisasi
        $userNorm     = $this->normalize($userResult);
        $expectedNorm = $this->normalize($expectedResult);

        if (!$orderMatters) {
            sort($userNorm);
            sort($expectedNorm);
        }

        // Kalau persis sama → 100
        if ($userNorm === $expectedNorm) return 100;

        // Hitung berapa baris yang cocok
        $matched   = 0;
        $remaining = $expectedNorm;

        foreach ($userNorm as $userRow) {
            $key = array_search($userRow, $remaining);
            if ($key !== false) {
                $matched++;
                unset($remaining[$key]);
                $remaining = array_values($remaining);
            }
        }

        $percent = $matched / count($expectedNorm);

        // Konversi ke nilai
        if ($percent >= 1.0)  return 100;
        if ($percent >= 0.75) return 80;
        if ($percent >= 0.5)  return 60;
        if ($percent >= 0.25) return 40;
        return 20;
    }

    private function normalize(array $rows): array
    {
        return array_map(function ($row) {
            $row = (array) $row;
            $row = array_change_key_case($row, CASE_LOWER);
            ksort($row);
            return array_map('strval', $row);
        }, $rows);
    }
}