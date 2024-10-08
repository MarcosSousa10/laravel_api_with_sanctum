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
        'filial_id',
    ];

    public $timestamps = true; // Usar timestamps padrão do Laravel

    // Relacionamentos
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }
}
