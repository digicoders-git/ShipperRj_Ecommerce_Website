<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    $user = User::create([
        'name' => 'Test User',
        'email' => 'test' . rand(100, 999) . '@example.com',
        'mobile' => '0000000' . rand(100, 999),
        'password' => Hash::make('password123'),
    ]);
    echo "User created with ID: " . $user->id . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
