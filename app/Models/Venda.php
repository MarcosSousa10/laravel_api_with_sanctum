<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [
        'produto_id',
        'cliente_id',
        'profissional_id',
        'quantidade',
        'preco_total',
        'data_venda'
    ];

    public function produto()
    {
        return $this->belongsTo(Inventario::class, 'produto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
}
