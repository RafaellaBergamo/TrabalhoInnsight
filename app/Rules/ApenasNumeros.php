<?php

namespace App\Rules;

use App\Helpers\DocumentoHelper;
use App\Models\Funcionario;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Hotel;

class ApenasNumeros implements Rule
{
    public function passes($attribute, $valor)
    {
        return preg_match('/^\d+$/', $valor);
    }

    public function message()
    {
        return "O campo deve conter apenas números.";
    }
}
