<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrateTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tareas', function (Blueprint $table) {
      
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hito_id');
            $table->foreign('hito_id')->references('id')->on('hitos')->onDelete('cascade');
            $table->unsignedBigInteger('miembro_id');
            $table->foreign('miembro_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->datetime('fecha_inicio');
            $table->tinyInteger('horas');
            $table->string('descripcion',300);
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('tareas');
    }
}
