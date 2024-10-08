<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramaFidelidade extends Model
{
    use HasFactory;

    protected $table = 'programa_fidelidade';

    protected $fillable = [
        'descricao',
        'disponibilidade_inicio',
        'disponibilidade_fim',
        'nome_recompensa',
        'pontos_necessarios',
        'filial_id',
    ];

    public $timestamps = true; // Usar timestamps padrão do Laravel
}
