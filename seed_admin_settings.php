<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$settings = [
    'global_cod_advance_percent' => '5',
    'global_cod_shipping' => '9',
    'global_online_shipping' => '0',
    'min_order_price' => '2000'
];

foreach($settings as $key => $value) {
    \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
}
echo "Settings seeded successfully.";
