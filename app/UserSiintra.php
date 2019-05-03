<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSiintra extends Model
{

    protected $table = 'usuarios';
    protected $primaryKey = "id_usuario";

    protected $fillable = [
        'id_usuario','login','password', 'tipo_usuario','cedula_usuario', 'nombre_usuario', 'apellido_usuario', 'intentos_fallidos', 'baneado'
    ];

    public function getAuthPassword()
    {
      return $this->password;
    }

}
