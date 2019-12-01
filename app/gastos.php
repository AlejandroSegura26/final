<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gastos extends Model
{
    
    protected $table = 'gastos';
    protected $filltable =['id_usuario','descripcion','fecha_gasto','estado','monto','id_metodo_pago','id_proyecto'];
    public $timestamps = false;
  
}
