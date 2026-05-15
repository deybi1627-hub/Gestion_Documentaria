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
        'fecha_transaccion'
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
