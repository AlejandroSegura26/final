<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MiembroProyecto extends Model
{
    protected $table = 'miembros_proyecto';
    protected $filltable =['id_proyecto','id_usuario','rol_proyecto'];
    public $timestamps = false;
    public function user(){
        return $this -> hasMany('App\User');
    }
    public function proyecto(){
        return $this -> hasOne('App\Proyecto');
    }
}
