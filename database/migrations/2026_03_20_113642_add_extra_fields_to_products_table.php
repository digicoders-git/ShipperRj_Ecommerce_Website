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
            if (!Schema::hasColumn('products', 'sku')) $table->string('sku')->nullable()->unique();
            if (!Schema::hasColumn('products', 'tags')) $table->string('tags')->nullable();
            if (!Schema::hasColumn('products', 'stock_status')) $table->string('stock_status')->default('In Stock');
            if (!Schema::hasColumn('products', 'brand')) $table->string('brand')->nullable();
            if (!Schema::hasColumn('products', 'manufacturer')) $table->string('manufacturer')->nullable();
            if (!Schema::hasColumn('products', 'seller_name')) $table->string('seller_name')->nullable();
            if (!Schema::hasColumn('products', 'featured')) $table->boolean('featured')->default(false);
            if (!Schema::hasColumn('products', 'trending')) $table->boolean('trending')->default(false);
            if (!Schema::hasColumn('products', 'return_policy')) $table->text('return_policy')->nullable();
            if (!Schema::hasColumn('products', 'warranty')) $table->text('warranty')->nullable();
            if (!Schema::hasColumn('products', 'dimensions')) $table->string('dimensions')->nullable();
            if (!Schema::hasColumn('products', 'weight')) $table->string('weight')->nullable();
            if (!Schema::hasColumn('products', 'shipping_charges')) $table->decimal('shipping_charges', 10, 2)->default(0);
            
            // Adding Pricing & Variant fields directly to products
            if (!Schema::hasColumn('products', 'mrp')) $table->decimal('mrp', 10, 2)->nullable();
            if (!Schema::hasColumn('products', 'selling_price')) $table->decimal('selling_price', 10, 2)->nullable();
            if (!Schema::hasColumn('products', 'stock')) $table->integer('stock')->default(0);
            if (!Schema::hasColumn('products', 'size')) $table->string('size')->nullable();
            if (!Schema::hasColumn('products', 'color')) $table->string('color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
