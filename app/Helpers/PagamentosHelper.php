<?php 

namespace App\Helpers;

use App\Mail\ConfirmacaoPagamento;
use App\Models\Hospede;
use App\Models\Pagamento;
use App\Models\Reserva;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;

class PagamentosHelper
{

    private static $formaPagamento = [
        'BOLETO' => Pagamento::BOLETO,
        'CARTAO_CREDITO' => Pagamento::CARTAO_CREDITO,
        'CARTAO_DEBITO' => Pagamento::CARTAO_DEBITO,
        'DINHEIRO' => Pagamento::DINHEIRO
    ];

    /**
     * Gera o comprovante de pagamento em pdf
     * 
     * @param int $idPagamento
     * @return JsonResponse|JsonResource
     */
    public static function enviarComprovantePorEmail(int $idPagamento)
    {
        $dadosPagamento = Pagamento::find($idPagamento);

        $hospede = Hospede::find($dadosPagamento->idHospede);

        $comprovante = self::gerarComprovante($dadosPagamento, $hospede['nome']);
        
        Mail::to('bergamorafaella@gmail.com')->send(new ConfirmacaoPagamento($comprovante));
    }

    public static function gerarComprovante(Pagamento $dadosPagamento, string $nomeHospede) 
    {
        $vlReserva = Reserva::find($dadosPagamento->idReserva)['vlReserva'];

        $dtPagamento = new DateTime($dadosPagamento->dtPagamento);

        $dadosComprovante = [
            "formaPagamento" => $dadosPagamento->formaPagamento,
            "dtPagamento" => $dtPagamento->format('d/m/Y'),
            "nomeHospede" => $nomeHospede,
            "vlTotal" => $vlReserva
        ];

        return Pdf::loadView('comprovantes.comprovante', $dadosComprovante);
    }

    /**
     * Retorna o valor inteiro correspondente a forma de pagamento escolhida pra salvar no banco
     * 
     * @param string $formaPagamentoString
     * @return int
     */
    public static function normalizarFormaPagamento(string $formaPagamentoString): int
    {
        return self::$formaPagamento[$formaPagamentoString];
    }

    /**
     * Retorna os dados do pagamento conforme o filtro enviado
     * 
     * @param int|null $idPagamento
     * @param int|null $idHospede
     * @param int|null $idReserva
     */
    public static function buscarDadosPagamento(
        int $idPagamento = null, 
        int $idHospede = null, 
        int $idReserva = null,
        int $formaPagamento = null,
        bool $apenasLiquidados = false
    ) {
        $dadosPagamento = Pagamento::query()
            ->when(!empty($idPagamento), function ($query) use ($idPagamento) {
                $query->where('id', '=', $idPagamento);
            })
            ->when(!empty($idHospede), function ($query) use ($idHospede) {
                $query->where('idHospede', '=', $idHospede);
            })
            ->when(!empty($idReserva), function ($query) use ($idReserva) {
                $query->where('idReserva', '=', $idReserva);
            })
            ->when(!empty($formaPagamento), function ($query) use ($formaPagamento) {
                $query->where('formaPagamento', '=', $formaPagamento);
            })
            ->when(!empty($apenasLiquidados), function ($query) {
                $query->whereNotNull('dtPagamento');
            })
            ->get();

        return $dadosPagamento;
    }
}