<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudproductos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_id');
            $table->foreign('solicitude_id')->references('id')->on('solicitudes');
            $table->unsignedInteger('tproducto_id');
            $table->foreign('tproducto_id')->references('id')->on('tproductos');
            $table->text('observaciones')->default("");
            $table->integer('cantidad')->default(0);
            $table->integer('terminado')->default(0);
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
        Schema::dropIfExists('solicitudproductos');
    }
}
