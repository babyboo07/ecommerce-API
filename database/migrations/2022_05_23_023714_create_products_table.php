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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',256);
            $table->text('description');
            $table->float('price');
            $table->integer('qty');
            $table->foreignId('cateId')->constrained('category');
            $table->string('material',256);
            $table->float('evaluate');
            $table->date('createdDate');
            $table->date('updatedDate');
            $table->integer('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
};
