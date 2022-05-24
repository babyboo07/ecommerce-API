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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullName',256);
            $table->string('email',256)->unique();
            $table->string('phone',11)->nullable();
            $table->string('password',256);
            $table->string('address',256)->nullable();
            $table->date('dob')->nullable();
            $table->boolean('gender')->nullable();
            $table->bigInteger('roleId')->unsigned();;
            $table->foreign('roleId')
                ->references('id')->on('roles');
            $table->string('imgPath',500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
