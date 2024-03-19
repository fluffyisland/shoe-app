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
        Schema::create('order_shoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('shoe_id');
            $table->unsignedBigInteger('shoe_color_id');
            $table->unsignedBigInteger('shoe_size_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('shoe_id')->references('id')->on('shoes');
            $table->foreign('shoe_color_id')->references('id')->on('shoe_colors');
            $table->foreign('shoe_size_id')->references('id')->on('shoe_sizes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_shoes');
    }
};
