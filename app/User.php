<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $table = "usuarios";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'correo_electronico', 'usuario', 'password', 'condicion', 'rol_id'
    ];

    //Se desactiva las propiedades para obtener la fecha y hora en que se inserto/actualizo un registro
    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    //Función para declarar la relación entre la tabla 'usuarios' y 'roles' donde a un usuario pertenece a un rol
    public function rol() {
        return $this->belongsTo('App\Rol');
    }
  public function inbox() {
        return $this->hasMany('App\inbox');
    }
}