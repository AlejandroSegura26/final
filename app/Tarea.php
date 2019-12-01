<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
   protected $table = 'tareas';
    protected $filltable =[ 
    //'imagen_mp',
    'id',
    'hito_id',
    'miembro_id',
    'fecha_inicio',
    'horas',
    'descripcion',
    'estado' ];
 
 
    public function MetodoPago(){
        return $this -> hasMany('App\Tarea');
    }
}
