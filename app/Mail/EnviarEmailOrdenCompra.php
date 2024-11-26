<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Tercero;
use App\Models\OrdenesCompra;
use Illuminate\Mail\Attachment;

class EnviarEmailOrdenCompra extends Mailable
{
    use SerializesModels;

    public $tercero;
    public $ordenCompra;
    public $pdfContent;

    public function __construct(Tercero $tercero, OrdenesCompra $ordenCompra, $pdfContent)
    {
        $this->tercero = $tercero;
        $this->ordenCompra = $ordenCompra;
        $this->pdfContent = $pdfContent;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Orden de Compra #' . $this->ordenCompra->id . ' - ' . config('app.name'),
            tags: ['orden-compra'],
            metadata: [
                'orden_id' => $this->ordenCompra->id,
                'tercero_id' => $this->tercero->id,
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.orden-compra',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromData(
                fn () => base64_decode($this->pdfContent),
                'orden-compra.pdf'
            )
        ];
    }
}