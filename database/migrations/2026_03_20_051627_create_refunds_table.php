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
        Schema::dropIfExists('refunds');
        Schema::create('refunds', function (Blueprint $table) {
            $table->string('id', 20)->primary();
            $table->string('order_id', 20);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('user_id', 20);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status')->default(1)->comment('1:pending, 2:approved, 3:rejected');
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};
