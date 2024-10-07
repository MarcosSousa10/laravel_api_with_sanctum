<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_hora_agendamento',
        'notas',
        'preco_total',
        'status',
        'cliente_id',
        'filial_id',
        'profissional_id',
        'servico_id',
    ];

    /**
     * Define a relação com a tabela clientes.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    /**
     * Define a relação com a tabela filiais.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class, 'filial_id');
    }

    /**
     * Define a relação com a tabela profissionais.
     */
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }

    /**
     * Define a relação com a tabela serviços.
     */
    public function servico()
    {
        return $this->belongsTo(Servico::class, 'servico_id');
    }
}
