<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/* Modelo que representa los usuarios del sistema con sus niveles de acceso */
class Usuario extends Model
{
    /* Nombre de la tabla en la base de datos */
    protected $table = 'usuarios';

    /* Campos asignables masivamente */
    protected $fillable = ['usuario', 'password', 'tipo_usuario'];

    /* Campos ocultos en serialización */
    protected $hidden = ['password'];

    /* Deshabilita updated_at ya que la tabla solo gestiona created_at */
    public $timestamps = false;
}
