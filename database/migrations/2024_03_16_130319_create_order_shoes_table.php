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
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shoe_id');
            $table->unsignedBigInteger('shoe_color_id');
            $table->unsignedBigInteger('shoe_size_id');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('slip_image')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Not paid, 1: Paid, 2: Cancelled');
            $table->timestamps();

            $table->foreign('shoe_id')->references('id')->on('shoes');
            $table->foreign('user_id')->references('id')->on('users');
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
