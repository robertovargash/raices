<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturaelementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturaelementos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('factura_id');
            $table->foreign('factura_id')->references('id')->on('facturas');
            $table->string('descripcion',250)->nullable()->default("");
            $table->string('um')->nullable()->default("");
            $table->decimal('cantidad', 18,6);
            $table->decimal('precio', 18,6);
            $table->integer('tipo')->nullable();//0-normal,1-recargo,2-descuento
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
        Schema::dropIfExists('facturaelementos');
    }
}
