<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcedimientoTupa extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'costo',
        'dias_laborales',
        'requisitos',
        'departamento_responsable',
        'activo'
    ];

    protected $casts = [
        'requisitos' => 'array',
        'costo' => 'decimal:2',
        'activo' => 'boolean'
    ];

    // Relationships
    public function tramites(): HasMany
    {
        return $this->hasMany(Tramite::class);
    }

    // Helper methods
    public function calcularFechaLimite($fechaInicio = null): \Carbon\Carbon
    {
        $fecha = $fechaInicio ? \Carbon\Carbon::parse($fechaInicio) : now();
        return $fecha->addWeekdays($this->dias_laborales);
    }
}
