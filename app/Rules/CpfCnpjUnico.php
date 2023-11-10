<?php

namespace App\Rules;

use App\Helpers\DocumentoHelper;
use App\Models\Funcionario;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Hotel;

class CpfCnpjUnico implements Rule
{
    protected $tipoDocumento = '';

    public function passes($attribute, $cpfCnpj)
    {
        $this->tipoDocumento = "CNPJ";
        $documento = preg_replace('/[^0-9]/', '', $cpfCnpj);

        if (DocumentoHelper::isCpf($documento)) {
            $this->tipoDocumento = "CPF";
            return self::cpfEmuso($documento);
        }

        return self::cnpjEmUso($documento);
    }

    public function message()
    {
        return "O {$this->tipoDocumento} informado já está em uso.";
    }
    
    static function cnpjEmUso($cnpj) {
        return !Hotel::where('cnpj', $cnpj)->exists();
    }

    static function cpfEmuso($cpf) {
        return !Funcionario::where('cpf', $cpf)->exists();
    }
}
