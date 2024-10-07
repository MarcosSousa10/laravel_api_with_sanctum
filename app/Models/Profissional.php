<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profissional extends Model
{
    use HasFactory;

    protected $table = 'profissionais';

    protected $fillable = [
        'disponibilidade',
        'email',
        'especialidade',
        'nome',
        'taxa_comissao',
        'telefone',
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
