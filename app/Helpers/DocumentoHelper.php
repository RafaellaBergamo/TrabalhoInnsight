<?php 

namespace App\Helpers;

class DocumentoHelper
{
    public static function isCpf(string $documento) {
        return strlen($documento) === 11;
    }

    public static function isCnpj(string $documento) {
        return strlen($documento) === 14;
    }

    public static function apenasNumeros($documento) {
        return preg_replace('/[^0-9]/', '', $documento);
    }
}