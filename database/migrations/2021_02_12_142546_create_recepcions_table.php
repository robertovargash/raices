<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recepcions', function (Blueprint $table) {
           $table->increments('id');

            $table->unsignedInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->unsignedInteger('numero')->default(0);
            $table->text('observaciones')->default("");
            $table->string('p_recibe',250)->default("");
            $table->string('p_entrega',250)->default("");
            $table->string('p_autoriza',250)->default("")->nullable();
            $table->string('contrato',250)->default("");
            $table->string('factura',250)->default("");
            $table->string('conduce',250)->default("");
            $table->string('scompra',250)->default("");
            $table->string('manifiesto',250)->default("");
            $table->string('partida',250)->default("");
            $table->string('conocimiento',250)->default("");
            $table->string('expedicion',250)->default("");
            $table->string('casilla',250)->default("");
            $table->integer('bultos')->default(0);
            $table->string('tbultos',50)->default("");
            $table->string('transportista',250)->default("");
            $table->string('tci',50)->default("");
            $table->string('tchapa',50)->default("");

            $table->string('proveedor',250)->default("");
            $table->timestamp('fecha');
            $table->integer('activo')->default(0);
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
        Schema::dropIfExists('recepcions');
    }
}
