<?php

namespace App\Services;

class SqlValidatorService
{
    public function validate(array $userResult, array $expectedResult, bool $orderMatters = false): bool
    {
        $userNorm     = $this->normalize($userResult);
        $expectedNorm = $this->normalize($expectedResult);

        // kalau urutan ndak penting, sort dulu
        if (!$orderMatters) {
            sort($userNorm);
            sort($expectedNorm);
        }

        return $userNorm === $expectedNorm;
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