<?php 

namespace App\Mail;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoPagamento extends Mailable
{
    use Queueable, SerializesModels;

    protected $comprovante;

    public function __construct(PDF $comprovante)
    {
        $this->comprovante = $comprovante;
    }

    public function build()
    {
        return $this->subject('Comprovante de Pagamento')
            ->view('emails.email_comprovante') // Use uma view para o corpo do e-mail se desejar
            ->attachData($this->comprovante->output(), 'comprovante.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
