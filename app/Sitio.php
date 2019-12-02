<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    protected $table = 'sitios';
    protected $filltable =['id','id_usuario','actividades','acercade','ubicacion','piepagina'];
    public function user() {
        return $this->belongsTo('App\User');
    }
}
