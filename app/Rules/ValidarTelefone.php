<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarTelefone implements Rule
{
    public function passes($attribute, $telefoneCelular)
    {
        return preg_match('/^\d{10}$|^\d{11}$/', $telefoneCelular);
    }

    public function message()
    {
        return 'O telefone/celular deve conter o formato de 10 (telefone) ou 11 (celular) dígitos';
    }        
}
