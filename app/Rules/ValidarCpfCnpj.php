<?php

namespace App\Rules;

use App\Helpers\DocumentoHelper;
use App\Models\Funcionario;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Hotel;

class ValidarCpfCnpj implements Rule
{
    public function passes($attribute, $cpfCnpj)
    {
        $documento = DocumentoHelper::apenasNumeros($cpfCnpj);

        if (strlen($documento) === 11) {
            return self::cpfValido($documento) && !self::cpfEmuso($documento);
        }

        return self::cnpjValido($documento) && !self::cnpjEmUso($documento);
    }

    public function message()
    {
        return 'O documento informado não é válido (CPF ou CNPJ).';
    }

    /**
     * Valida se o CPF enviado é válido
     * 
     * @param string $cpf
     * @return bool
     */
    static function cpfValido(string $cpf): bool
    {
       // Remova formatação (pontos e traços) do CPF
       $cpf = preg_replace('/[^0-9]/', '', $value);

       // Verifique se o CPF tem 11 dígitos
       if (strlen($cpf) !== 11) {
           return false;
       }

       // Obtenha os nove primeiros dígitos do CPF
       $novePrimeirosDigitos = substr($cpf, 0, 9);

       // Calcule os dígitos verificadores do CPF
       $primeiroDigitoVerificador = self::calcularDigitoVerificadorCpf($novePrimeirosDigitos, 10);
       $segundoDigitoVerificador = self::calcularDigitoVerificadorCpf($novePrimeirosDigitos . $primeiroDigitoVerificador, 11);

       // Verifique se os dígitos verificadores calculados são iguais aos dígitos originais
       return ($primeiroDigitoVerificador == $cpf[9] && $segundoDigitoVerificador == $cpf[10]);
    }

    static function cnpjValido($cnpj) {
         // Remove os dois dígitos verificadores do CNPJ
        $cnpjLimpo = substr($cnpj, 0, 12);

        // Calcula o primeiro dígito verificador
        $primeiroDigito = self::calcularDigitoVerificadorCnpj($cnpjLimpo, 5);

        // Calcula o segundo dígito verificador
        $segundoDigito = self::calcularDigitoVerificadorCnpj($cnpjLimpo . $primeiroDigito, 6);

        // Verifica se os dígitos verificadores calculados são iguais aos dígitos originais
        return ($cnpjLimpo . $primeiroDigito . $segundoDigito === $cnpj);
    }
    
    static function calcularDigitoVerificadorCnpj($cnpj, $posicao)
    {
        $soma = 0;
        $multiplicador = $posicao;
    
        for ($i = 0; $i < strlen($cnpj); $i++) {
            $soma += $cnpj[$i] * $multiplicador;
            $multiplicador--;
    
            if ($multiplicador < 2) {
                $multiplicador = 9;
            }
        }
    
        $resto = $soma % 11;
    
        if ($resto < 2) {
            return 0;
        } else {
            return 11 - $resto;
        }
    }

    private function calcularDigitoVerificadorCpf($base, $posicao)
    {
        $soma = 0;

        for ($i = 0; $i < strlen($base); $i++) {
            $soma += $base[$i] * $posicao--;
        }

        $resto = $soma % 11;

        if ($resto < 2) {
            return 0;
        } else {
            return 11 - $resto;
        }
    }
    
    static function cnpjEmUso($cnpj) {
        return Hotel::where('cnpj', $cnpj)->exists();
    }

    static function cpfEmuso($cpf) {
        return Funcionario::where('cpf', $cpf)->exists();
    }
}
