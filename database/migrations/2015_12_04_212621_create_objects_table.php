<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('objects', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('comment');

            $table->date('return_date')->nullable();
            $table->integer('available');
            $table->integer('locked');
            $table->integer('working');
            $table->integer('complete');
            $table->integer('color');

            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('type_id')->unsigned();
            $table->integer('location_id')->unsigned()->nullable();
            $table->integer('source_id')->unsigned()->nullable();

            /*$table->foreign('user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('type_id')->references('id')->on('types');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('source_id')->references('id')->on('sources');*/

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
        Schema::drop('objects');
    }
}
