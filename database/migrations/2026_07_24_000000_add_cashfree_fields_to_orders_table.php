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
            if (!Schema::hasColumn('orders', 'cashfree_order_id')) {
                $table->string('cashfree_order_id')->nullable()->after('razorpay_payment_id');
            }
            if (!Schema::hasColumn('orders', 'cashfree_payment_id')) {
                $table->string('cashfree_payment_id')->nullable()->after('cashfree_order_id');
            }
            if (!Schema::hasColumn('orders', 'cashfree_session_id')) {
                $table->string('cashfree_session_id')->nullable()->after('cashfree_payment_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['cashfree_order_id', 'cashfree_payment_id', 'cashfree_session_id']);
        });
    }
};
