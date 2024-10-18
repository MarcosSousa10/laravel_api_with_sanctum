<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvaliacaoDeServico extends Model
{
    use HasFactory;

    // Define o nome da tabela, se diferente do padrão
    protected $table = 'avaliacoes_de_servicos';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'comentario',
        'nota',
        'agendamento_id',
        'cliente_id',
    ];

    /**
     * Define a relação com a tabela agendamentos.
     */
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    /**
     * Define a relação com a tabela clientes.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
