<?php 

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificacaoEstoque extends Mailable
{
    use Queueable, SerializesModels;

    protected $produto;

    public function __construct($produto)
    {
        $this->produto = $produto;
    }

    public function build()
    {
        return $this->view('emails.estoque_baixo')
        ->with([
            "produto" => $this->produto
        ]);
    }
}
