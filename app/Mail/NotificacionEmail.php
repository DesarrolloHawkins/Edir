<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\Alertas;

class NotificacionEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $alerta;
    public $archivoPath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Alertas $alerta, $archivoPath = null)
    {
        $this->alerta = $alerta;
        $this->archivoPath = $archivoPath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        $tipoTexto = is_numeric($this->alerta->tipo) 
            ? ($this->alerta->tipo == 1 ? 'Urgente' : 'Informativo')
            : $this->alerta->tipo;
        
        $tipoColor = ($tipoTexto == 'Urgente' || $tipoTexto == 1) ? '🔴 URGENTE' : 'ℹ️ Informativo';
        
        return new Envelope(
            subject: $tipoColor . ' - ' . $this->alerta->titulo,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.notificacion',
            with: [
                'alerta' => $this->alerta,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        $attachments = [];
        
        if ($this->archivoPath && file_exists(storage_path('app/' . $this->archivoPath))) {
            $attachments[] = Attachment::fromPath(storage_path('app/' . $this->archivoPath));
        }
        
        return $attachments;
    }
}
