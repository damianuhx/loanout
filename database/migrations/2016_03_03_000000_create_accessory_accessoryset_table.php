<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccessoryAccessorysetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accessory_accessoryset', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('accessory_id')->unsigned();
            $table->foreign('accessory_id')->references('id')->on('accessories');

            $table->integer('accessoryset_id')->unsigned();
            $table->foreign('accessoryset_id')->references('id')->on('accessorysets');

            $table->timestamps();

            $table->unique(['accessory_id', 'accessoryset_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('accessory_accessoryset');
    }
}
