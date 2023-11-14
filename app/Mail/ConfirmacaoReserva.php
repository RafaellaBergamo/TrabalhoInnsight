<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoReserva extends Mailable
{
    use Queueable, SerializesModels;

    protected $reserva;
    protected $nomeHospede;

    public function __construct($nomeHospede, $reserva)
    {
        $this->reserva = $reserva;
        $this->nomeHospede = $nomeHospede;
    }

    public function build()
    {
        return $this->view('emails.confirmacao_reserva')
        ->with([
            "mensagem" => "Olá, {$this->nomeHospede}! Sua reserva foi confirmada com sucesso.",
            "reserva" => $this->reserva
        ]);
    }
}
