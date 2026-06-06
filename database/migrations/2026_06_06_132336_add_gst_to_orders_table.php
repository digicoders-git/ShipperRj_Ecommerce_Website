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
            $table->boolean('has_gst')->default(0);
            $table->string('gst_number')->nullable();
            $table->string('gst_company')->nullable();
            $table->decimal('gst_amount', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['has_gst', 'gst_number', 'gst_company', 'gst_amount']);
        });
    }
};
