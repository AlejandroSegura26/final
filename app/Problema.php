<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Problema extends Model
{
    protected $table = 'problemas';
    protected $filltable =['id','usuario_id','descripcion','estado','proyecto_id'];
    public function user() {
        return $this->belongsTo('App\User');
    }
    public function proyectos() {
        return $this->belongsTo('App\Proyecto');
    }

}