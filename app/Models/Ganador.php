<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ganador extends Model
{
    protected $table = 'ganadores';
    protected $primaryKey = 'id_ganador';

    protected $fillable = [
        'id_prueba',
        'id_equipo',
        'id_ciclista',
    ];

    public function prueba(): BelongsTo
    {
        return $this->belongsTo(Prueba::class, 'id_prueba', 'id');
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    public function ciclista(): BelongsTo
    {
        return $this->belongsTo(Ciclista::class, 'id_ciclista', 'id_ciclistas');
    }
}
