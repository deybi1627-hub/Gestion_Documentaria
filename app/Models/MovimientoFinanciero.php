<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MovimientoFinanciero extends Model
{
    use HasFactory;

    protected $fillable = [
        'tramite_id',
        'tipo',
        'categoria',
        'monto',
        'descripcion',
        'comprobante_path',
        'estado',
        'fecha_transaccion',
        'aprobado_por',
        'fecha_aprobacion',
        'notas_internas',
    ];

    protected $casts = [
        'monto' => 'decimal:2',
        'fecha_transaccion' => 'datetime'
    ];

    // Relationships
    public function tramite(): BelongsTo
    {
        return $this->belongsTo(Tramite::class);
    }

    /** Auditoría: quien aprobó o rechazó el pago */
    public function aprobador(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'aprobado_por');
    }

    // Scopes
    public function scopeIngresos($query)
    {
        return $query->where('tipo', 'ingreso');
    }

    public function scopeEgresos($query)
    {
        return $query->where('tipo', 'egreso');
    }

    public function scopePagados($query)
    {
        return $query->where('estado', 'pagado');
    }
}
