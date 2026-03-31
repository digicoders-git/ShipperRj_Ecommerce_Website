<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$product = \App\Models\Product::where('id', 'PRDRVRZL2')->first();
if($product) {
    $product->update([
        'cod_advance_percent' => 7.00,
        'cod_shipping_charges' => 15.00,
        'online_shipping_charges' => 5.00
    ]);
    echo "Product PRDRVRZL2 updated with custom 7% advance and 15rs COD shipping.";
} else {
    echo "Product not found.";
}
