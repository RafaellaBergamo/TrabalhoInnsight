<?php

namespace App\Rules;

use DateTime;
use Illuminate\Contracts\Validation\Rule;

class ValidarData implements Rule
{
    public function passes($attribute, $data)
    {
        return (bool) DateTime::createFromFormat("d/m/Y", $data);
    }

    public function message()
    {
        return "As datas devem estar no formado d/m/Y.";
    }
}
