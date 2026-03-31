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
        Schema::dropIfExists('offers');
        Schema::create('offers', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('product_id', 20);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->decimal('discount_percentage', 5, 2);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
