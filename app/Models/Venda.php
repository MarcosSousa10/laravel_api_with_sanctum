<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'vendas';

    protected $fillable = [
        'cliente_id',
        'profissional_id',
        'preco_total',
        'data_venda'
    ];

    public function inventario()
    {
        return $this->belongsToMany(Inventario::class, 'venda_produto', 'venda_id', 'inventario_id');
    }
    public function produtos()
    {
        return $this->belongsToMany(Inventario::class, 'venda_produto')
            ->withPivot('quantidade', 'preco_total') // Permite acessar esses campos na tabela de pivô
            ->withTimestamps(); // Adiciona timestamps automaticamente, se necessário
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
