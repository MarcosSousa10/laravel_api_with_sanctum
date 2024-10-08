<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produto';

    protected $fillable = [
        'descricao',
        'estoquecd',
        'estoquedispothon',
        'estoqueothon',
        'giromes',
        'produtopai',
        'qtachegar',
        'qtvendida3meses',
        'unidade',
    ];

    public $timestamps = false; // Não utilizar timestamps padrão do Laravel
}
