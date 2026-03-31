<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Force truncate to clear any corrupted indexes/data
\DB::table('settings')->truncate();

$settings = [
    'global_cod_advance_percent' => '5',
    'global_cod_shipping' => '9',
    'global_online_shipping' => '0',
    'min_order_price' => '2000',
    'min_free_delivery_amount' => '500',
    'support_email' => 'support@shoppingclubindia.com',
    'support_phone' => '+91 999 999 9999',
    'cashback_percentage' => '0'
];

foreach($settings as $key => $value) {
    \App\Models\Setting::create(['key' => $key, 'value' => $value]);
}

echo "Settings table RECONSTRUCTED successfully.";
