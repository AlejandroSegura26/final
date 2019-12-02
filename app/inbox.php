<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inbox extends Model
{
    protected $table = 'inbox';
    protected $filltable =[ 
    'fecha_envio',
    'id_proyecto',
    'mensaje',
    'emisor',
    'receptor'];
    public $timestamps = false;
    
  
   public function users() {
        return $this->hasMany('App\User');
    }
}
