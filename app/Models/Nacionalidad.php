<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nacionalidad extends Model
{
    protected $table = 'nacionalidades';
    protected $primaryKey = 'id_nacionalidad';

    protected $fillable = [
        'codigo_iso',
        'nombre',
    ];

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class, 'id_nacionalidad', 'id_nacionalidad');
    }

    public function ciclistas(): HasMany
    {
        return $this->hasMany(Ciclista::class, 'id_nacionalidad', 'id_nacionalidad');
    }
}