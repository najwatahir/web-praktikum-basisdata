<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SqlSandboxService
{
    private string $prefix;

    public function __construct()
    {
        $this->prefix = 'sb_' . Str::random(8) . '_';
    }

    public function run(string $schemaSql, string $userQuery): array
    {
        try {
            // hanya bisa select
            if (!$this->isSafeQuery($userQuery)) {
                return [
                    'status'  => 'error',
                    'message' => 'Query tidak diizinkan. Hanya SELECT yang diperbolehkan.',
                    'data'    => [],
                ];
            }

            $schema    = $this->addPrefix($schemaSql);
            $userQuery = $this->addPrefixToQuery($userQuery, $schemaSql);

            //timeout 10 detik
            DB::connection('sandbox')->statement("SET SESSION max_execution_time=10000");

            $statements = array_filter(
                array_map('trim', explode(';', $schema)),
                fn($s) => !empty($s)
            );

            foreach ($statements as $statement) {
                DB::connection('sandbox')->unprepared($statement);
            }

            $result = DB::connection('sandbox')->select($userQuery);

            return [
                'status' => 'success',
                'data'   => $result,
            ];

        } catch (\Exception $e) {
            return [
                'status'  => 'error',
                'message' => $this->cleanErrorMessage($e->getMessage()),
                'data'    => [],
            ];
        } finally {
            $this->cleanup($schemaSql);
        }
    }

    private function isSafeQuery(string $query): bool
    {
        $query   = trim(strtoupper($query));
        $blocked = ['INSERT', 'UPDATE', 'DELETE', 'DROP', 'CREATE', 'ALTER', 'TRUNCATE', 'EXEC', 'EXECUTE'];

        foreach ($blocked as $keyword) {
            if (str_starts_with($query, $keyword)) {
                return false;
            }
        }

        return str_starts_with($query, 'SELECT') || str_starts_with($query, 'WITH');
    }

    private function addPrefix(string $sql): string
    {
        return preg_replace_callback(
            '/\b(CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?)`?(\w+)`?/i',
            fn($m) => $m[1] . $this->prefix . $m[2],
            $sql
        );
    }

    private function addPrefixToQuery(string $userQuery, string $schemaSql): string
    {
        preg_match_all('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(\w+)`?/i', $schemaSql, $matches);
        $tables = $matches[1] ?? [];

        foreach ($tables as $table) {
            $userQuery = preg_replace(
                '/\b' . preg_quote($table, '/') . '\b/',
                $this->prefix . $table,
                $userQuery
            );
        }

        return $userQuery;
    }

    private function cleanup(string $schemaSql): void
    {
        try {
            preg_match_all('/CREATE\s+TABLE\s+(?:IF\s+NOT\s+EXISTS\s+)?`?(\w+)`?/i', $schemaSql, $matches);
            $tables = $matches[1] ?? [];

            foreach ($tables as $table) {
                DB::connection('sandbox')
                    ->unprepared("DROP TABLE IF EXISTS `{$this->prefix}{$table}`");
            }
        } catch (\Exception $e) {
        }
    }

    private function cleanErrorMessage(string $message): string
    {
        $message = preg_replace('/sb_\w+_/', '', $message);
        return $message;
    }
}