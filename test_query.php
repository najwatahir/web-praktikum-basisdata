<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kelompok = "0";

$query = \App\Models\Submission::with(['participant', 'question'])
    ->join('participants', 'submissions.nim', '=', 'participants.nim')
    ->select('submissions.*')
    ->orderByDesc('submissions.created_at');

if ($kelompok !== null && $kelompok !== '') {
    $query->where('participants.kelompok', $kelompok);
}

echo $query->toSql() . "\n";
echo json_encode($query->getBindings()) . "\n";
