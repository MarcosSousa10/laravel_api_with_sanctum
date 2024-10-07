<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $fillable = [
        'descricao',
        'duracao',
        'nome',
        'preco',
        'filial_id',
        'imagem',
    ];

    /**
     * Define a relação com a tabela filiais.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }
}
