<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Documento extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'tipo',
        'descripcion',
        'archivo_path',
        'fecha_publicacion',
        'tramite_id',
        'categoria',
        'departamento',
        'confidencial',
        'version'
    ];

    protected $casts = [
        'fecha_publicacion' => 'datetime',
        'confidencial' => 'boolean'
    ];

    // Relationships
    public function tramite(): BelongsTo
    {
        return $this->belongsTo(Tramite::class);
    }

    public function archivo(): HasOne
    {
        return $this->hasOne(Archivo::class);
    }
}