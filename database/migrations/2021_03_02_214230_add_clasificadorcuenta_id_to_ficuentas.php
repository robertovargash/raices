<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClasificadorcuentaIdToFicuentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ficuentas', function (Blueprint $table) {
            $table->unsignedInteger('clasificadorcuenta_id')->nullable()->after('id');
            $table->foreign('clasificadorcuenta_id')->references('id')->on('clasificadorcuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ficuentas', function (Blueprint $table) {
            $table->dropConstrainedForeignId('clasificadorcuenta_id');
        });
    }
}
