<?php

namespace App\Helpers;

use App\Models\Funcionario;
use Illuminate\Support\Facades\Hash;

class FuncionariosHelper
{
    /**
     * Retorna todos os funcionários que fazem parte da governança
     */
    public static function buscarGovernanca(int $idHotel)
    {
        return Funcionario::query()
            ->where("idHotel", "=", $idHotel)
            ->where("tipo", "=", Funcionario::GOVERNANCA)
            ->get();
    }

    /**
     * Verifica se o funcionário tem o acesso desejado
     * 
     * @param string $email
     * @param string $senha
     * @param array $acessos
     * 
     * @return bool
     */
    public static function funcionarioComAcesso(string $email, string $senha, array $acessos): bool
    {
        $funcionario = Funcionario::where('email', '=', $email)->first();
        dd($funcionario);
        return !empty($funcionario) && Hash::check($senha, $funcionario->senha) && in_array($funcionario->tipo, $acessos);
    }

    /**
     * Retorna se o tipo da funcionário é válido
     * 
     * @param int $tipo
     * @return bool
     */
    public static function tipoFuncionarioValido(int $tipo): bool
    {
        $tiposValidos = [Funcionario::COMUM, Funcionario::GOVERNANCA, Funcionario::MASTER];

        return in_array($tipo, $tiposValidos);
    }
}