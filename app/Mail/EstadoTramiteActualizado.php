<?php

namespace App\Mail;

use App\Models\Tramite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EstadoTramiteActualizado extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Tramite $tramite,
        public readonly string  $estadoAnterior
    ) {}

    public function envelope(): Envelope
    {
        $estadoEmoji = match($this->tramite->estado) {
            'En Revisión' => '🔍',
            'Aprobado'    => '✅',
            'Rechazado'   => '❌',
            'Finalizado'  => '📦',
            default       => '📋',
        };

        return new Envelope(
            subject: "{$estadoEmoji} Tu trámite {$this->tramite->numero_expediente} ha sido actualizado",
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.tramite_estado',
            with: [
                'tramite'        => $this->tramite,
                'estadoAnterior' => $this->estadoAnterior,
                'urlSeguimiento' => route('tramites.show', $this->tramite),
            ],
        );
    }
}
