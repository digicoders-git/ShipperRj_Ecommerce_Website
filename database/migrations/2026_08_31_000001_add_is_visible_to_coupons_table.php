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
        if (!Schema::hasColumn('coupons', 'is_visible')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->boolean('is_visible')->default(1)->after('status')->comment('1: Show on Website, 0: Hide on Website');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('coupons', 'is_visible')) {
            Schema::table('coupons', function (Blueprint $table) {
                $table->dropColumn('is_visible');
            });
        }
    }
};
