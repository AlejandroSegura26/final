<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pservicios extends Model
{
     protected $table = 'pservicios';
    protected $filltable =['id_proyecto','id_servicio'];
    public $timestamps = false;
}
