<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplatesDeNotificacoes extends Model
{
    use HasFactory;

    protected $table = 'templates_de_notificacoes';

    protected $fillable = [
        'conteudo_template',
        'nome_template',
        'tipo_template',
    ];

    public $timestamps = true; // Usar timestamps padrão do Laravel
}
