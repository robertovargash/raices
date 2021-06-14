<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudmateriasprimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudmateriasprimas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_id');
            $table->foreign('solicitude_id')->references('id')->on('solicitudes');
            $table->unsignedInteger('mercancia_id');
            $table->foreign('mercancia_id')->references('id')->on('mercancias');
            $table->unsignedInteger('solicitudproducto_id');
            $table->foreign('solicitudproducto_id')->references('id')->on('solicitudproductos');
            $table->decimal('cantidad', 18,2)->nullable()->default(0);
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
        Schema::dropIfExists('solicitudmateriasprimas');
    }
}
