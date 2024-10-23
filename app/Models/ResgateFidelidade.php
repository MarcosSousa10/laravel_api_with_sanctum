<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResgateFidelidade extends Model
{
    use HasFactory;

    protected $table = 'resgates_fidelidade';

    protected $fillable = [
        'cliente_id',
        'recompensa_id',
        'pontos_utilizados',
    ];

    public $timestamps = true;

    // Relacionamento com o cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    // Relacionamento com a recompensa
    public function recompensa()
    {
        return $this->belongsTo(ProgramaFidelidade::class, 'recompensa_id');
    }
}
