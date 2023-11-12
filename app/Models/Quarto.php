<?php

namespace App\Models;

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
}
