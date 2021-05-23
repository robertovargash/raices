<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaprimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiaprimas', function (Blueprint $table) {
            $table->increments('id');       
            $table->unsignedInteger('tproducto_id');
            $table->foreign('tproducto_id')->references('id')->on('tproductos');

            $table->unsignedInteger('mercancia_id');
            $table->foreign('mercancia_id')->references('id')->on('mercancias');
            
            $table->decimal('cantidadnecesaria', 18,6);
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
        Schema::dropIfExists('materiaprimas');
    }
}
