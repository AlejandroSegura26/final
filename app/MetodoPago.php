<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MetodoPago extends Model
{
    protected $table = 'metodo_pagos';
    protected $filltable =[ 
    //'imagen_mp',
    'id',
    'nombre_mp',
    'cantidad_minretiro',
    'cantidad_maxretiro',
    'cargo_retiro',
    'porcentaje_cargo',
    'taza_mp',
    'moneda_mp',
    'dias_habiles',
    'estado_mp'];
    public $timestamps = false;


    public function MetodoPago(){
        return $this -> hasMany('App\MetodoPago');
    }
}