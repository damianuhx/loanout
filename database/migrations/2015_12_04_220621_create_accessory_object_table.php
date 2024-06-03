<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoryObjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory_object', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('accessory_id')->unsigned();
            $table->foreign('accessory_id')->references('id')->on('accessories');

            $table->integer('object_id')->unsigned();
            $table->foreign('object_id')->references('id')->on('objects');

            $table->timestamps();

            $table->unique(['accessory_id', 'object_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accessory_object');
    }
}
