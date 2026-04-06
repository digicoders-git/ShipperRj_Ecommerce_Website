<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->index('is_blocked');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('order_status');
            $table->index('payment_status');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->index('status');
            $table->index('featured');
            $table->index('trending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['is_blocked']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_status']);
            $table->dropIndex(['payment_status']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['featured']);
            $table->dropIndex(['trending']);
        });
    }
};
