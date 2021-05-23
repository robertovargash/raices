<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiinfracuentassTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiinfracuentas', function (Blueprint $table) {
            $table->increments('id');      
            $table->unsignedInteger('fisubcuenta_id');
            $table->foreign('fisubcuenta_id')->references('id')->on('fisubcuentas');      
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
        Schema::dropIfExists('fiinfracuentas');
    }
}
