<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = \App\Models\Product::where('cod_advance_percent', '>', 0)
    ->orWhere('online_shipping_charges', '>', 0)
    ->orWhere('cod_shipping_charges', '>', 0)
    ->get(['id', 'name', 'cod_advance_percent', 'online_shipping_charges', 'cod_shipping_charges']);

echo "Products with custom settings:".PHP_EOL;
foreach($products as $p) {
    echo "ID: [".$p->id."] NAME: [".$p->name."] ADV: [".$p->cod_advance_percent."] ON_SHIP: [".$p->online_shipping_charges."] COD_SHIP: [".$p->cod_shipping_charges."]".PHP_EOL;
}
