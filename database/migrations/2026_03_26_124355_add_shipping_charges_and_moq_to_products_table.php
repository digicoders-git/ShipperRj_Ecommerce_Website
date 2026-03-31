<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('online_shipping_charges', 10, 2)->default(0)->after('shipping_charges');
            $table->decimal('cod_shipping_charges', 10, 2)->default(0)->after('online_shipping_charges');
            $table->integer('minimum_order_quantity')->default(1)->after('stock');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['online_shipping_charges', 'cod_shipping_charges', 'minimum_order_quantity']);
        });
    }
};
