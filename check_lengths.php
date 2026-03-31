<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = \App\Models\Setting::all();
foreach($settings as $s) {
    echo "KEY: [".$s->key."] LEN: ".strlen($s->key)." => VALUE: [".$s->value."] LEN: ".strlen($s->value).PHP_EOL;
}
