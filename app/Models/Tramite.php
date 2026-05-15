<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tramite extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_expediente',
        'user_id',
        'procedimiento_tupa_id',
        'estado',
        'descripcion',
        'requisitos_completados',
        'fecha_inicio',
        'fecha_limite',
        'fecha_finalizacion',
        'observaciones'
    ];

    protected $casts = [
        'requisitos_completados' => 'array',
        'fecha_inicio' => 'datetime',
        'fecha_limite' => 'datetime',
        'fecha_finalizacion' => 'datetime'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function procedimientoTupa(): BelongsTo
    {
        return $this->belongsTo(ProcedimientoTupa::class);
    }

    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class);
    }

    public function movimientos(): HasMany
    {
        return $this->hasMany(TramiteMovimiento::class)->orderBy('created_at', 'desc');
    }

    public function movimientosFinancieros(): HasMany
    {
        return $this->hasMany(MovimientoFinanciero::class);
    }

    // Helper methods
    public function generarNumeroExpediente(): string
    {
        return 'EXP-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function estaVencido(): bool
    {
        return $this->fecha_limite && now()->isAfter($this->fecha_limite) && $this->estado !== 'Finalizado';
    }
}
