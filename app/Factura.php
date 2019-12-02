<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
       protected $table = 'facturas';
    protected $filltable =[ 
    //'imagen_mp',
    'id',
    'codigo_factura',
    'razon',
    'cliente_id',
      'manager_id',
    'metodo_id',
    'fecha_factura',
    'vencimiento_factura',
    'estado_factura',
    'monto',
    'monto_pagado' ];
    public $timestamps = false;

 
    public function MetodoPago(){
        return $this -> hasMany('App\Factura');
    }
}
