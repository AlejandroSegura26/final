<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetodoCantPagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metodo_cant_pago', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('cantidad_actual',11,2);
            $table->unsignedBigInteger('id_metodo_pago');
            $table->foreign('id_metodo_pago')->references('id')->on('metodo_pagos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metodo_cant_pago');
    }
}
