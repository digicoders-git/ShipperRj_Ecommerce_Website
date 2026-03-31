<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = \App\Models\Setting::all()->pluck('value', 'key');
echo json_encode($settings, JSON_PRETTY_PRINT);
