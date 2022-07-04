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
        Schema::create('purchased_products', function (Blueprint $table) {
            $table->id('orderId');
            $table->foreignId('productId')->constrained('product');
            $table->integer('orderQty');
            $table->integer('orderEvaluate')->nullable();
            $table->string('comment',500)->nullable();
            $table->foreignId('userId')->constrained('users');
            $table->integer('status');
            $table->date('createdDate')->nullable();
            $table->date('updatedDate')->nullable();
            $table->integer('orderDiscount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchased_products');
    }
};
