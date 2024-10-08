<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContaAPagar extends Model
{
    use HasFactory;

    protected $table = 'contas_a_pagar';

    protected $fillable = [
        'data_pagamento',
        'data_vencimento',
        'descricao',
        'nome_fornecedor',
        'status',
        'valor',
        'filial_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_pagamento',
        'data_vencimento',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com a tabela de filiais.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }
}
