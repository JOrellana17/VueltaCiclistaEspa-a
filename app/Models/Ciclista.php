<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Ciclista extends Model
{
    protected $table = 'ciclistas';
    protected $primaryKey = 'id_ciclistas';

    protected $fillable = [
        'id_equipo',
        'id_nacionalidad',
        'nombre',
        'fecha_nacimiento',
        'fecha_inicio_contrato',
        'fecha_fin_contrato',
        'estado_contrato',
        'estado',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    public function nacionalidad(): BelongsTo
    {
        return $this->belongsTo(Nacionalidad::class, 'id_nacionalidad', 'id_nacionalidad');
    }

}