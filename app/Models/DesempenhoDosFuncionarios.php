<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesempenhoDosFuncionarios extends Model
{
    use HasFactory;

    protected $table = 'desempenho_dos_funcionarios';

    protected $fillable = [
        'data_registro',
        'tipo_metrica',
        'valor_metrica',
        'profissional_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'data_registro',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com a tabela de profissionais.
     */
    public function profissional()
    {
        return $this->belongsTo(Profissional::class, 'profissional_id');
    }
}
