<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Tercero;
use App\Models\SolicitudesOferta;
use Illuminate\Mail\Attachment;

class EnviarEmailTercero extends Mailable
{
    use Queueable, SerializesModels;

    public $tercero;
    public $solicitudOferta;
    public $pdfContent;

    public function __construct(Tercero $tercero, SolicitudesOferta $solicitudOferta, $pdfContent)
    {
        $this->tercero = $tercero;
        $this->solicitudOferta = $solicitudOferta;
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Solicitud de Oferta #' . $this->solicitudOferta->id . ' - ' . config('app.name'),
            tags: ['solicitud-oferta'],
            metadata: [
                'solicitud_id' => $this->solicitudOferta->id,
                'tercero_id' => $this->tercero->id,
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.solicitud-oferta',
        );
    }

        /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => base64_decode($this->pdfContent),
                'solicitud-oferta.pdf'
            )
        ];
    }
}