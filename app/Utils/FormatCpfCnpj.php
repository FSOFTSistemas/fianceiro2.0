<?php

namespace App\Utils;

use Illuminate\Support\Str;

class FormatCpfCnpj {

    public static function format($content)
    {
        $numeros = preg_replace('/\D/', '', $content);

        if (strlen($content) === 14 && Str::contains($content, '.')) {
            return $content;
        }

        if (strlen($content) === 18 && Str::contains($content, '/')) {
            return $content;
        }

        if (strlen($numeros) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $numeros);
        } elseif (strlen($numeros) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $numeros);
        }

        return $content;
    }

}
