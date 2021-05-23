<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMercanciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mercancias', function (Blueprint $table) {
            $table->increments('id');

            $table->string('codigo',50);

            $table->unsignedInteger('clasificacion_id');
            $table->foreign('clasificacion_id')->references('id')->on('clasificacions');

            // $table->integer('clasificacioncontable')->nullable();

            $table->string('nombremercancia',1000);

            $table->string('descripcion',1000)->nullable();

            $table->string('um',50);

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
        Schema::dropIfExists('mercancias');
    }
}
