<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromocoesAtivas extends Model
{
    use HasFactory;

    protected $table = 'promocoes_ativas';

    protected $fillable = [
        'data_inicio',
        'data_fim',
        'desconto',
        'nome',
        'descricao',
        'filial_id',
    ];

    public $timestamps = true; // Usar timestamps padrão do Laravel
}
