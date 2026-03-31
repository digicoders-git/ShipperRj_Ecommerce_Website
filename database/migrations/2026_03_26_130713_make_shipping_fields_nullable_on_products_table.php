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
            $table->decimal('online_shipping_charges', 10, 2)->nullable()->change();
            $table->decimal('cod_shipping_charges', 10, 2)->nullable()->change();
            $table->decimal('cod_advance_percent', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('online_shipping_charges', 10, 2)->default(0)->change();
            $table->decimal('cod_shipping_charges', 10, 2)->default(0)->change();
            $table->decimal('cod_advance_percent', 10, 2)->default(0)->change();
        });
    }
};
