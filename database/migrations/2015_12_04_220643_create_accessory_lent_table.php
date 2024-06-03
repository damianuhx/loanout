<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoryLentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory_lent', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('accessory_id')->unsigned();
            $table->foreign('accessory_id')->references('id')->on('accessories');

            $table->integer('lent_id')->unsigned();
            $table->foreign('lent_id')->references('id')->on('lents');

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
        Schema::drop('accessory_lent');
    }
}
