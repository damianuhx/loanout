<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('company');
            $table->string('title');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('addition');
            $table->string('street');
            $table->string('number');
            $table->integer('zip');
            $table->string('city');
            $table->string('country');
            $table->string('language');
            $table->boolean('reseller');
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
        Schema::drop('customers');
    }
}
