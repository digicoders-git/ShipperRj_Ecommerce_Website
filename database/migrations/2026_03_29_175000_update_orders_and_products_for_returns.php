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
            if (!Schema::hasColumn('orders', 'advance_paid')) {
                $table->decimal('advance_paid', 10, 2)->default(0)->after('total_amount');
            }
            if (!Schema::hasColumn('orders', 'refund_amount')) {
                $table->decimal('refund_amount', 10, 2)->default(0)->after('advance_paid');
            }
            if (!Schema::hasColumn('orders', 'refund_status')) {
                $table->string('refund_status')->nullable()->after('refund_amount'); // pending, processed, failed
            }
            if (!Schema::hasColumn('orders', 'cancel_reason')) {
                $table->text('cancel_reason')->nullable()->after('refund_status');
            }
            if (!Schema::hasColumn('orders', 'return_status')) {
                $table->string('return_status')->nullable()->after('cancel_reason'); // Return Requested, Approved, Pickup, Refunded
            }
            if (!Schema::hasColumn('orders', 'return_reason')) {
                $table->text('return_reason')->nullable()->after('return_status');
            }
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('return_reason');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'return_days')) {
                $table->integer('return_days')->default(7)->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['advance_paid', 'refund_amount', 'refund_status', 'cancel_reason', 'return_status', 'return_reason', 'delivered_at']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('return_days');
        });
    }
};
