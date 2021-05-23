<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProveedorcuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedorcuentas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('banco',250)->nullable()->default("");
            $table->string('sucursal',250)->nullable()->default("");
            $table->string('cuenta',250)->nullable()->default("");
            $table->string('moneda')->nullable()->default("");
            $table->unsignedInteger('proveedor_id');
            $table->foreign('proveedor_id')->references('id')->on('proveedors');
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
        Schema::dropIfExists('proveedorcuentas');
    }
}
