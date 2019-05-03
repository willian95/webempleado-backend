<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "usuarios";
    protected $primaryKey = 'id_usuario';
    protected $rememberTokenName = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $fillable = [
        'name', 'email', 'password',
    ];*/
    protected $fillable = [
        'id_usuario', 'login', 'password', 'tipo_usuario', 'cedula_usuario', 'nombre_usuario', 'apellido_usuario', 'intentos_fallidos', 'baneado'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password', 'remember_token',
    ];*/
    protected $hidden = [
        'password'
    ];
}
