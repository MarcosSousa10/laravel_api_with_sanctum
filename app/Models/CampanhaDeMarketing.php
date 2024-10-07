<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampanhaDeMarketing extends Model
{
    use HasFactory;
    protected $table = 'campanhas_de_marketing';

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_fim',
        'descricao',
        'orçamento',
        'status',
        'filial_id',
    ];

    /**
     * Define a relação com a tabela filiais.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
