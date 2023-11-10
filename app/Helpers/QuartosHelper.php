<?php

namespace App\Helpers;

use App\Models\Quarto;
use Symfony\Component\Console\Helper\Helper;

class QuartosHelpers
{
    public static function quartoDisponivel(int $idQuarto) {
        return Quarto::find($idQuarto)['status'] === Quarto::DISPONIVEL;
    }
}