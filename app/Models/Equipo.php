<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id_equipo';

    protected $fillable = [
        'nombre',
        'director',
        'id_nacionalidad',
        'estado',
    ];

    public function nacionalidad(): BelongsTo
    {
        return $this->belongsTo(Nacionalidad::class, 'id_nacionalidad', 'id_nacionalidad');
    }

    public function ciclistas(): HasMany
    {
        return $this->hasMany(Ciclista::class, 'id_equipo', 'id_equipo');
    }

    public function participaciones(): HasMany
    {
        return $this->hasMany(Participa::class, 'id_equipo', 'id_equipo');
    }
}