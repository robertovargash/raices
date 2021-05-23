<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',400)->nullable()->default("");
            $table->string('siglas',250)->nullable()->default("");
            $table->text('direccion')->nullable()->default("");
            $table->string('reeup',250)->nullable()->default("");
            $table->string('nit',250)->nullable()->default("");
            $table->string('telefono',250)->nullable()->default("");
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
        Schema::dropIfExists('clientes');
    }
}
