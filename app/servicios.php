<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class servicios extends Model
{
    protected $table = 'servicios';
    protected $filltable =['nombre','estado','costo'];
    public $timestamps = false;
}
