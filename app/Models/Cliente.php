<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cpf_cnpj',
        'ie',
        'situacao',
        'vencimento',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'cep',
    ];

    public function installments()
    {
        return $this->hasMany(ContasAReceber::class, 'cliente_id');
    }

}
