<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;

    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;
    const COMUM = 0;
    const GOVERNANCA = 1;
    const MASTER = 2;

    protected $fillable = [
        'nome', 
        'cpf', 
        'status',
        'tipo',
        'idHotel',
        'email'
    ];
}
