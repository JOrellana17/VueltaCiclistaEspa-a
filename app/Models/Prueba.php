<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Prueba extends Model
{
    protected $table = 'pruebas';

    protected $fillable = [
        'nombre',
        'numero_etapas',
        'anio_edicion',
        'km_totales',
        'estado',
    ];

    public function ganador(): HasOne
    {
        return $this->hasOne(Ganador::class, 'id_prueba', 'id');
    }

    public function participaciones(): HasMany
    {
        return $this->hasMany(Participa::class, 'id_prueba', 'id');
    }
}