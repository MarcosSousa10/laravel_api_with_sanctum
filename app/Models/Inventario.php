<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'descricao',
        'nome_produto',
        'preco',
        'quantidade',
        'filial_id',
        'fornecedor_id',
    ];

    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    public function vendas()
    {
        return $this->belongsToMany(Venda::class, 'venda_produto')
            ->withPivot('quantidade', 'preco_total') // Permite acessar esses campos na tabela de pivô
            ->withTimestamps();
    }
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'fornecedor_id');
    }
}
