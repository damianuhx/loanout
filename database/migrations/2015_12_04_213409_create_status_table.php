<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\State;

class CreateStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('states', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('name_de')->unique();
            $table->string('name_fr')->unique();
            $table->string('name_en')->unique();
            $table->timestamps();
        });

        State::create(['name'=>'reserved', 'name_de'=>'reserviert', 'name_fr'=>'reservé', 'name_en'=>'reserved']);
        State::create(['name'=>'granted', 'name_de'=>'bewilligt', 'name_fr'=>'granté', 'name_en'=>'granted']);
        State::create(['name'=>'handed', 'name_de'=>'verschickt', 'name_fr'=>'envoyé', 'name_en'=>'sent']);
        State::create(['name'=>'restocked', 'name_de'=>'zurückerhalten', 'name_fr'=>'retourné', 'name_en'=>'returned']);
        State::create(['name'=>'refused', 'name_de'=>'abgelehnt', 'name_fr'=>'refusé', 'name_en'=>'refused']);
        State::create(['name'=>'in_stock', 'name_de'=>'an Lager', 'name_fr'=>'prêt', 'name_en'=>'in stock']);
        State::create(['name'=>'lost', 'name_de'=>'verloren', 'name_fr'=>'perdu', 'name_en'=>'lost']);
        State::create(['name'=>'lock', 'name_de'=>'gesperrt', 'name_fr'=>'fermé', 'name_en'=>'locked']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('states');
    }
}
