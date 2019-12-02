<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class metodocantpago extends Model
{
    protected $table = 'metodo_cant_pago';
    protected $filltable =['cantidad_actual','id_metodo_pago'];
    public $timestamps = false;
}
