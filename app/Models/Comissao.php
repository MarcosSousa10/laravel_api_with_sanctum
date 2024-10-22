<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;

    // Define o nome da tabela no banco de dados
    protected $table = 'comissoes';

    // Define os campos que podem ser atribuídos em massa
    protected $fillable = [
        'agendamento_id',
        'venda_id', // Incluído campo para venda
        'profissional_id',
        'taxa_comissao',
        'valor_comissao',
    ];

    /**
     * Define a relação com o agendamento.
     * Cada comissão pode estar relacionada a um agendamento.
     */
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'agendamento_id');
    }

    /**
     * Define a relação com a venda.
     * Cada comissão pode estar relacionada a uma venda.
     */
    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    /**
     * Define a relação com o profissional.
     * Cada comissão pertence a um profissional.
     */
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
}
