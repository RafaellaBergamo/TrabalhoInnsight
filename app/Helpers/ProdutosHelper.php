<?php 

namespace App\Helpers;

use App\Mail\NotificacaoEstoque;
use App\Models\Funcionario;
use App\Models\Produto;
use Illuminate\Support\Facades\Mail;

class ProdutosHelper
{
    /**
     * Envia um email pra todos os funcionários da governança, informando estoque baixo do produto
     * 
     * @param Produto $produto
     */
    public static function notificarEstoqueBaixo(Produto $produto) 
    {
        $emailsGovernanca = Funcionario::where('tipo', '=', Funcionario::GOVERNANCA)
            ->get('email');

        Mail::to($emailsGovernanca)->send(new NotificacaoEstoque($produto));
    }

    /**
     * Retorna os produtos baseado nos dados pra busca informados
     * 
     * @param int|null $idProduto
     * @param int|null $idHotel
     * @param string $descricao
     */
    public static function buscarProdutos(int $idProduto = null, int $idHotel = null, string $descricao = '') 
    {
        $queryBuscarProduto = Produto::query()
            ->when(!empty($idProduto), function ($query) use ($idProduto) {
                $query->where('id', '=', $idProduto);
            })
            ->when(!empty($idHotel), function ($query) use ($idHotel) {
                $query->where('idHotel', '=', $idHotel);
            })
            ->when(!empty($descricao), function ($query) use ($descricao) {
                $query->where('descricao', 'LIKE', "%{$descricao}%");
            });

        return $queryBuscarProduto->get();
    }
}