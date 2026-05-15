<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TramiteMovimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'tramite_id',
        'user_id',
        'estado_anterior',
        'estado_nuevo',
        'departamento_origen',
        'departamento_destino',
        'comentarios',
        'adjuntos',
        'fecha_movimiento'
    ];

    protected $casts = [
        'adjuntos' => 'array',
        'fecha_movimiento' => 'datetime'
    ];

    // Relationships
    public function tramite(): BelongsTo
    {
        return $this->belongsTo(Tramite::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
