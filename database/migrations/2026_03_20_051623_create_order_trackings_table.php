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
        Schema::dropIfExists('order_trackings');
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('order_id', 20);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('status');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_trackings');
    }
};
