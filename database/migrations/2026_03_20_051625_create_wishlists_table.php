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
        Schema::dropIfExists('wishlists');
        Schema::create('wishlists', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('product_id', 20);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
