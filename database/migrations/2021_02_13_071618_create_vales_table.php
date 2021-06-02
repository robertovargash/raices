<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vales', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacens');
            $table->unsignedInteger('numero')->default(0);
            $table->text('observaciones')->default("");
            $table->string('p_solicita',250)->default("")->nullable();
            $table->string('p_entrega',250)->default("")->nullable();
            $table->string('p_autoriza',250)->default("")->nullable();
            $table->date('fecha');
            $table->integer('activo')->default(0);
            $table->integer('tipovale')->default(0);
            $table->unsignedInteger('ordentrabajo_id');
            $table->foreign('ordentrabajo_id')->references('id')->on('ordentrabajos')->nullable();
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
        Schema::dropIfExists('vales');
    }
}
