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
        Schema::table('offers', function (Blueprint $table) {
            if (Schema::hasColumn('offers', 'product_id')) {
                $table->string('product_id', 20)->nullable()->change();
            }
            if (Schema::hasColumn('offers', 'discount_percentage')) {
                $table->decimal('discount_percentage', 5, 2)->nullable()->change();
            }
            if (!Schema::hasColumn('offers', 'category_id')) {
                $table->string('category_id', 20)->nullable()->after('id');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            }
            if (!Schema::hasColumn('offers', 'offer_name')) {
                $table->string('offer_name')->nullable()->after('category_id');
            }
            if (!Schema::hasColumn('offers', 'offer_type')) {
                $table->string('offer_type')->default('Special Offer')->after('offer_name');
            }
            if (!Schema::hasColumn('offers', 'discount_type')) {
                $table->string('discount_type', 20)->default('percentage')->after('offer_type');
            }
            if (!Schema::hasColumn('offers', 'discount_value')) {
                $table->decimal('discount_value', 10, 2)->default(0.00)->after('discount_type');
            }
            if (!Schema::hasColumn('offers', 'image')) {
                $table->string('image')->nullable()->after('end_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            if (Schema::hasColumn('offers', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('offers', 'offer_name')) {
                $table->dropColumn('offer_name');
            }
            if (Schema::hasColumn('offers', 'offer_type')) {
                $table->dropColumn('offer_type');
            }
            if (Schema::hasColumn('offers', 'discount_type')) {
                $table->dropColumn('discount_type');
            }
            if (Schema::hasColumn('offers', 'discount_value')) {
                $table->dropColumn('discount_value');
            }
            if (Schema::hasColumn('offers', 'image')) {
                $table->dropColumn('image');
            }
        });
    }
};
