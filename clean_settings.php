<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = \App\Models\Setting::all();
foreach($settings as $s) {
    $clean_val = trim(preg_replace('/\s+/', ' ', $s->value));
    $s->update(['value' => $clean_val]);
}
echo "Settings cleaned successfully.";
