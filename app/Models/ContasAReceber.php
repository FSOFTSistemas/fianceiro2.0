<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasAReceber extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'descricao',
        'valor',
        'data_vencimento',
        'data_recebimento',
        'status',
    ];
    
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
