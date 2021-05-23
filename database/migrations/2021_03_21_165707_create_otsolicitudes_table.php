<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtsolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otsolicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ordentrabajo_id');
            $table->foreign('ordentrabajo_id')->references('id')->on('ordentrabajos');
            $table->unsignedInteger('solicitude_id');
            $table->foreign('solicitude_id')->references('id')->on('solicitudes');
            $table->unsignedInteger('cantidad')->default(0);
            $table->unsignedInteger('terminado')->default(0);
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
        Schema::dropIfExists('otsolicitudes');
    }
}
