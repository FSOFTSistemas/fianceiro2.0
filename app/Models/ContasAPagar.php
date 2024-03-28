<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContasAPagar extends Model
{
    use HasFactory;

    protected $fillable = [
        'fornecedor',
        'descricao',
        'valor',
        'data_vencimento',
        'data_pagamento',
        'status',
    ];
}
