<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento_id',
        'ubicacion_fisica',
        'codigo_archivo',
        'anio',
        'departamento',
        'estado',
        'fecha_archivacion',
        'fecha_destruccion',
        'notas'
    ];

    protected $casts = [
        'fecha_archivacion' => 'datetime',
        'fecha_destruccion' => 'datetime'
    ];

    // Relationships
    public function documento(): BelongsTo
    {
        return $this->belongsTo(Documento::class);
    }

    // Helper methods
    public function generarCodigoArchivo(): string
    {
        return 'ARCH-' . $this->anio . '-' . $this->departamento . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }

    public function debeDestruirse(): bool
    {
        return $this->fecha_destruccion && now()->isAfter($this->fecha_destruccion);
    }
}
