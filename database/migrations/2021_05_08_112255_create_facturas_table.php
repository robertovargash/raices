<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('numero')->default(0);
            $table->unsignedInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->date('fecha');
            $table->integer('estado')->default(0)->nullable();
            $table->string('elabora',250)->nullable()->default("");
            $table->string('entrega',250)->nullable()->default("");
            $table->string('recibe',250)->nullable()->default("");
            $table->string('transporta',250)->nullable()->default("");
            $table->string('tchapa',250)->nullable()->default("");
            $table->string('tci',250)->nullable()->default("");
            $table->text('descripcion')->nullable()->default("");
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
        Schema::dropIfExists('facturas');
    }
}
