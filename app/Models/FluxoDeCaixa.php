<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FluxoDeCaixa extends Model
{
    use HasFactory;
    protected $fillable = [
        'descricao',
        'valor',
        'data_transacao',
        'tipo',
        'plano_contas_id'
    ];

    public function planoDeContas()
    {
        return $this->belongsTo(PlanoDeContas::class, 'plano_contas_id');
    }
}
