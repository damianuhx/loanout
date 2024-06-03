<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLentObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lent_object', function (Blueprint $table) {
        $table->increments('id');

        $table->integer('lent_id')->unsigned();
        $table->foreign('lent_id')->references('id')->on('lents');

        $table->integer('object_id')->unsigned();
        $table->foreign('object_id')->references('id')->on('objects');

        $table->timestamps();

        $table->unique(['lent_id', 'object_id']);

    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lent_object');
    }
}
