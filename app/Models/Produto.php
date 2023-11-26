<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    const QUANTIDADE_MINIMA = 5;

    protected $fillable = [
        'descricao', 
        'qtdProduto',
        'idHotel'
    ];
}
