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

    /**
     * Veriica se o pagamento da reserva foi efetuado
     * 
     * @param int $idReserva
     * @return bool
     */
    public static function pagamentoPendente(int $idReserva): bool
    {
        $pagamento = Pagamento::query()
            ->where('idReserva', '=', $idReserva)
            ->where('dtPagamento', '=', null)
            ->count();

        return !empty($pagamento);
    }

    /**
     * Gera um registro na tabela Pagamentos referente a reserva
     * 
     * @param int $idHospede
     * @param int $idReserva
     * 
     * @return void
     */
    public static function gerarPagamentoPendente(int $idHospede, int $idReserva) 
    {
        Pagamento::create([
            'idHospede' => $idHospede,
            'idReserva' => $idReserva
        ]);
    }

    /**
     * Verifica se a forma de pagamento escolhida pelo cliente é inválida
     * 
     * @param string $formaPagamento
     * @return bool
     */
    public static function formaPagamentoValida(string $formaPagamento): bool
    {
        $formasValidas = [
            'BOLETO' => self::BOLETO,
            'CARTAO_CREDITO' => self::CARTAO_CREDITO,
            'CARTAO_DEBITO' => self::CARTAO_DEBITO,
            'DINHEIRO' => self::DINHEIRO
        ];

        if (!isset($formasValidas[$formaPagamento])) {
            return false;
        }

        return true;
    }
}
