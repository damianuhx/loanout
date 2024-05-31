<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('comment');

            $table->float('fee')->nullable();
            $table->integer('available')->nullable();
            $table->integer('full')->nullable();
            $table->integer('partial')->nullable();
            $table->integer('missing')->nullable();
            $table->integer('color')->nullable();

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->integer('accessoryset_id')->unsigned()->nullable();
            $table->foreign('accessoryset_id')->references('id')->on('accessorysets');

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
        Schema::drop('types');
    }
}
