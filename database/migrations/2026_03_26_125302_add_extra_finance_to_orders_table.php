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
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('shipping_amount', 10, 2)->default(0)->after('total_amount');
            $table->decimal('coupon_discount', 10, 2)->default(0)->after('shipping_amount');
            $table->string('coupon_code')->nullable()->after('coupon_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['shipping_amount', 'coupon_discount', 'coupon_code']);
        });
    }
};
