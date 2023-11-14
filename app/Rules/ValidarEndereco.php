<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidarEndereco implements Rule
{
    public function passes($attribute, $endereco)
    {
        $enderecoParts = explode(',', $endereco);
        $rua = '';
        $numero = '';
        $cep = '';

        foreach ($enderecoParts as $parte) {
            $parte = trim($parte);

            if (self::cepValido($parte)) {
                $cep = $parte;
            } elseif (self::numeroValido($parte)) {
                $numero = $parte;
            } else {
                $rua .= "{$parte} ";
            }
        }

        return !empty($rua) && !empty($numero) && !empty($cep);
    }

    public function message()
    {
        return 'O endereço deve conter a rua, o número e o cep.';
    }

    public static function cepValido(string $cep) 
    {
        return preg_match('/^\d{5}-\d{3}$/', $cep);
    }

    public static function numeroValido(string $numeroRua) 
    {
        return preg_match('/^\d+(?:-\d+)?$/', $numeroRua);
    }
}
