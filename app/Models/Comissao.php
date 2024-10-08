<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comissao extends Model
{
    use HasFactory;
    protected $table = 'comissoes';

    protected $fillable = [
        'agendamento_id',
        'profissional_id',
        'taxa_comissao',
        'valor_comissao',
    ];

    /**
     * Define a relação com o agendamento.
     */
    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class);
    }

    /**
     * Define a relação com o profissional.
     */
    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }
}
