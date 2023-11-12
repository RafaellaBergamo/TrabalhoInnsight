<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarto extends Model
{
    use HasFactory;

    const DISPONIVEL = 0;
    const OCUPADO = 1;
    const SUJO = 2;

    protected $fillable = [
        'idHotel', 
        'qtdCamas',
        'capacidade',
        'status'
    ];

    public static function buscarQuartos(int $idHotel, int $idQuarto = null) 
    {
        $query = Quarto::query();

        $query->where('idHotel', $idHotel);
        if (!empty($idQuarto)) {
            $query->where('id', $idQuarto);
        }

        return $query->get();
    }

        /**
     * Atualiza os dados do quarto informado
     * 
     * @param int $idQuarto
     * @param int $idHotel
     * @param array $dados
     */
    public static function atualizarDadosQuarto(int $idQuarto, int $idHotel, array $dados) 
    {
        $quarto = Quarto::buscarQuartos($idHotel, $idQuarto)->first();

        if (empty($quarto)) {
            throw new Exception("Hotel informado não possui quarto cadastrado.", 404);
        }

        $quarto->update($dados);

        return $quarto;
    }
}
