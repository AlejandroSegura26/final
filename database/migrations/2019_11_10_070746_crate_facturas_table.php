<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
      
            $table->bigIncrements('id');
            $table->string('codigo_factura',10);
            $table->string('razon',100);
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('manager_id');
            $table->foreign('manager_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('metodo_id');
            $table->foreign('metodo_id')->references('id')->on('metodo_pagos')->onDelete('cascade');
            $table->dateTime('fecha_factura');
            $table->dateTime('vencimiento_factura');
            $table->tinyInteger('estado_factura');
            $table->decimal('monto');
            $table->decimal('monto_pagado');
        });
    } 
     
                    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
