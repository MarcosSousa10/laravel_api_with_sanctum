<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracaoDoSistema extends Model
{
    use HasFactory;

    protected $table = 'configuracoes_do_sistema';

    protected $fillable = [
        'chave_configuracao',
        'descricao',
        'ultima_atualizacao',
        'valor_configuracao',
    ];

    public $timestamps = false; // Desabilita os timestamps automáticos

    /**
     * Define que 'ultima_atualizacao' é um campo de data.
     */
    protected $dates = [
        'ultima_atualizacao',
    ];
}
