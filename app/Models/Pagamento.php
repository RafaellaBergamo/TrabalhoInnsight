<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;

    const BOLETO = 0;
    const CARTAO_CREDITO = 1;
    const CARTAO_DEBITO = 2;
    const DINHEIRO = 3;

    protected $fillable = [
        'idHospede', 
        'idReserva',
        'dtPagamento',
        'formaPagamento'
    ];
}
