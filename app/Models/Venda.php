<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $table = 'vendas';

    protected $fillable = [
        'data_venda',
        'metodo_pagamento',
        'valor_total',
        'cliente_id',
        'filial_id',
        'profissional_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
}
