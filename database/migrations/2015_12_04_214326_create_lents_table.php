<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lents', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states');

            $table->string('purpose');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->boolean('shipping');

            $table->integer('granter_id')->unsigned()->nullable();

            $table->date('reserved_at')->nullable();
            $table->date('granted_at')->nullable();
            $table->date('handed_at')->nullable();
            $table->date('returned_at')->nullable();
            $table->date('stored_at')->nullable();
            $table->date('return_at')->nullable();

            $table->string('comment')->nullable();

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
        Schema::drop('lents');
    }
}
