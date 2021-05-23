<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCuentaToMercancias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mercancias', function (Blueprint $table) {
            $table->unsignedInteger('ficuenta_id')->nullable()->after('clasificacion_id');
            $table->foreign('ficuenta_id')->references('id')->on('ficuentas');

            $table->unsignedInteger('fisubcuenta_id')->nullable()->after('ficuenta_id');
            $table->foreign('fisubcuenta_id')->references('id')->on('fisubcuentas');

            $table->unsignedInteger('fiinfracuenta_id')->nullable()->after('fisubcuenta_id');
            $table->foreign('fiinfracuenta_id')->references('id')->on('fiinfracuentas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mercancias', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ficuenta_id');
            $table->dropConstrainedForeignId('fisubcuenta_id');
            $table->dropConstrainedForeignId('fiinfracuenta_id');
        });
    }
}
