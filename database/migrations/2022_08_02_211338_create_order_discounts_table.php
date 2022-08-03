<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('capain_code');
            $table->decimal('minimum_order_amount')->nullable();
            $table->enum('minimum_amount_type',['decimal','percent'])->default('decimal');
            $table->decimal('minimum_amount_discount',10,2)->default('0');
            $table->integer('buy_qty')->default(0);
            $table->integer('free_product_count')->default(0);
            $table->integer('categoty_product_count')->default(0);
            $table->decimal('cheapest_product_discount',10,2)->default('0');
            $table->boolean('status')->default(1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_discounts');
    }
};
