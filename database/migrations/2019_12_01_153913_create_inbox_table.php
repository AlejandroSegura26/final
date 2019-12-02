<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inbox', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fecha_envio');
            $table->string('mensaje');
            $table->unsignedBigInteger('id_proyecto');
            $table->foreign('id_proyecto')->references('id')->on('proyecto')->onDelete('cascade');
            $table->unsignedBigInteger('emisor');
             
            $table->foreign('emisor')->references('id')->on('usuarios')->onDelete('cascade');
            $table->unsignedBigInteger('receptor');
            $table->foreign('receptor')->references('id')->on('usuarios')->onDelete('cascade');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice');
    }
}
