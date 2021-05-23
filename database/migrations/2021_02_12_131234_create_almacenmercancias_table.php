<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlmacenmercanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('almacenmercancias', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacens');

            $table->unsignedInteger('mercancia_id');
            $table->foreign('mercancia_id')->references('id')->on('mercancias');

            $table->decimal('cantidad', 18,6);      
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
        Schema::dropIfExists('almacenmercancias');
    }
}
