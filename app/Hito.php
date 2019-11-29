<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hito extends Model
{
    protected $table = 'hitos';
    protected $filltable =[ 
    'id',
    'id_proyecto',
    'titulo',
    'fecha_inicio',
    'fecha_fin',
    'descripcion'];
    public $timestamps = false;


    public function Hito(){
        return $this -> hasMany('App\Hito');
    }
}
