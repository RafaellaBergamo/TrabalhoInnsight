<?php

namespace App\Rules;

use App\Helpers\DocumentoHelper;
use App\Models\Hotel;
use Illuminate\Contracts\Validation\Rule;

class IsFilial implements Rule
{

    public function passes($attribute, $cnpj)
    {
        $cnpj = DocumentoHelper::apenasNumeros($cnpj);

        if (!DocumentoHelper::isCnpj($cnpj)) {
            return false;
        }

        return self::isFilial($cnpj);
    }

    public function message()
    {
        return 'O cnpj informado não pertence à nossa rede.';
    }

    public static function isFilial(string $cnpj) 
    {
        if (empty(Hotel::count())) {
            return true;
        }

        $cnpjComparar = Hotel::select('cnpj')->first();

        if (substr($cnpj, 0, 8) == substr($cnpjComparar, 0, 8)) {
            if (substr($cnpj, 8, 4) != substr($cnpjComparar, 8, 4)) {
                return true;
            }
        }

        return false;
    }
}
