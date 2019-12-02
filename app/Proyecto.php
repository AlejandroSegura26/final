<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    protected $table = 'proyecto';
    protected $filltable =['titulo','cliente_id','fecha_inicio','fecha_fin','descripcion','manager_id','estado'];
    public $timestamps = false;
    public function user(){
        return $this -> hasOne('App\User');
    }
    public function problemas() {
        return $this->hasMany('App\Problema');
    }
}