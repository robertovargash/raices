<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValeitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valeitems', function (Blueprint $table) {
            $table->increments('id');
    
                $table->unsignedInteger('vale_id');
                $table->foreign('vale_id')->references('id')->on('vales');
    
                $table->unsignedInteger('mercancia_id');
                $table->foreign('mercancia_id')->references('id')->on('mercancias');
    
                $table->decimal('cantidad', 18,6);
                $table->decimal('precio', 18,6);            
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
        Schema::dropIfExists('valeitems');
    }
}
