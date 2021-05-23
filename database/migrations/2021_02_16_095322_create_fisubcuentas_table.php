<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiSubcuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fisubcuentas', function (Blueprint $table) {
            $table->increments('id');      
            $table->unsignedInteger('ficuenta_id');
            $table->foreign('ficuenta_id')->references('id')->on('ficuentas');      
            $table->string('numero',50);
            $table->string('descripcion',250)->default("");     
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
        Schema::dropIfExists('fi_subcuentas');
    }
}
