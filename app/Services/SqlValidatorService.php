<?php

namespace App\Services;

class SqlValidatorService
{
    // cek benar/salah total
    public function validate(array $userResult, array $expectedResult, bool $orderMatters = false): bool
    {
        return $this->score($userResult, $expectedResult, $orderMatters) === 100;
    }

    public function score(array $userResult, array $expectedResult, bool $orderMatters = false, string $userQuery = ''): int
    {
        if (empty($expectedResult)) return 0;
        if (empty($userResult)) return 0;

        $expectedKeys = array_keys((array) $expectedResult[0]);
        $userKeys     = array_keys((array) $userResult[0]);

        $expectedKeys = array_map('strtolower', $expectedKeys);
        $userKeys     = array_map('strtolower', $userKeys);
        sort($expectedKeys);
        sort($userKeys);

        if ($expectedKeys !== $userKeys) return 0;

        $userNorm     = $this->normalize($userResult);
        $expectedNorm = $this->normalize($expectedResult);

        if (!$orderMatters) {
            sort($userNorm);
            sort($expectedNorm);
        }

        $isResultMatch = ($userNorm === $expectedNorm);

        if ($isResultMatch) {
            if ($orderMatters && !preg_match('/\bORDER\s+BY\b/i', $userQuery)) {
                return 80; 
            }
            return 100;
        }

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

        // FIX: Gunakan jumlah baris terbanyak sebagai pembagi.
        // Jika expected 1 baris, tapi mahasiswa return 2 baris, pembaginya jadi 2.
        // Hasilnya: 1 / 2 = 0.5 (50%), bukan lagi 100%.
        $divisor = max(count($expectedNorm), count($userNorm));
        $percent = $matched / $divisor;

        // Pastikan partial score maksimal adalah 90, karena 100 hanya untuk yang sempurna
        if ($percent >= 0.99) return 90;
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