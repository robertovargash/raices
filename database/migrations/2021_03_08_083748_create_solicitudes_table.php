<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('numero')->default(0);
            $table->string('cliente',250)->nullable();
            $table->string('telefono',250)->nullable();
            $table->integer('pagada')->default(0)->nullable();
            $table->integer('alpedido')->default(0)->nullable();
            $table->date('fechasolicitud');
            $table->date('fechaentrega')->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('estado')->default(0);
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
        Schema::dropIfExists('solicitudes');
    }
}
