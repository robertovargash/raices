<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdentrabajosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordentrabajos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('tproducto_id');
            $table->foreign('tproducto_id')->references('id')->on('tproductos');
            $table->unsignedInteger('numero')->default(0);
            $table->integer('estado')->default(0);
            $table->text('observaciones')->nullable();
            $table->date('fecha');
            $table->unsignedInteger('cantidad')->default(0);
            $table->string('tecnico',250)->default("");
            $table->string('operario',250)->default("");
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
        Schema::dropIfExists('ordentrabajos');
    }
}
