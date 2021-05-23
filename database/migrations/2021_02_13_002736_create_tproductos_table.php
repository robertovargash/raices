<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tproductos', function (Blueprint $table) {
            $table->increments('id');       
            $table->string('nombre',250);
            $table->text('descripcion');
            $table->unsignedInteger('tipotproducto_id')->nullable();
            $table->foreign('tipotproducto_id')->references('id')->on('tipotproductos');
            $table->decimal('preciomanoobra',18,6)->default(0);
            $table->decimal('valorbruto', 18,6);            
            $table->integer('disponible')->default(1);
            $table->integer('disponiblemprima')->default(1);
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
        Schema::dropIfExists('tproductos');
    }
}
