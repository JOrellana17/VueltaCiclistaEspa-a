<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Participa extends Model
{
    use HasFactory;

    protected $table = 'participas';
    protected $primaryKey = 'id_participa';

    protected $fillable = [
        'id_equipo',
        'id_prueba',
        'fecha_inicio',
        'fin_contrato',
        'estado',
    ];

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class, 'id_equipo', 'id_equipo');
    }

    public function prueba(): BelongsTo
    {
        return $this->belongsTo(Prueba::class, 'id_prueba', 'id');
    }
}
