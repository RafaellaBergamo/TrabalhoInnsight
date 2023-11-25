<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Pessoa;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticatableTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword;

class Funcionario extends Pessoa implements CanResetPasswordContract
{
    use HasFactory, AuthenticatableTrait, CanResetPassword, Notifiable;

    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;
    const COMUM = 0;
    const GOVERNANCA = 1;
    const MASTER = 2;

    protected $fillable = [
        'nome', 
        'cpf',
        'telefone',
        'email',
        'tipo',
        'idHotel',
        'senha'
    ];
}
