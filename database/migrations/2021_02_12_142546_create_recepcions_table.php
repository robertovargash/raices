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
            $table->string('contrato',50)->default("");
            $table->string('factura',50)->default("");
            $table->string('conduce',50)->default("")->nullable();
            $table->string('scompra',50)->default("")->nullable();
            $table->string('manifiesto',50)->default("")->nullable();
            $table->string('partida',50)->default("")->nullable();
            $table->string('conocimiento',50)->default("")->nullable();
            $table->string('expedicion',50)->default("")->nullable();
            $table->string('casilla',50)->default("")->nullable();
            $table->integer('bultos')->default(0)->nullable();
            $table->string('tbultos',50)->default("")->nullable();
            $table->string('transportista',250)->default("")->nullable();
            $table->string('tci',50)->default("")->nullable();
            $table->string('tchapa',50)->default("")->nullable();

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
