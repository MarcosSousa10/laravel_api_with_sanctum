<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transacoes extends Model
{
    use HasFactory;

    protected $table = 'transacoes';

    protected $fillable = [
        'data_transacao',
        'metodo_pagamento',
        'valor_pago',
        'agendamento_id',
        'venda_id', // Adicionando venda_id
        'filial_id',
    ];

    public $timestamps = true;

    // Relacionamentos
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id'); // Relacionamento com venda
    }
}
