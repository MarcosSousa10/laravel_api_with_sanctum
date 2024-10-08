<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComunicacaoCliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'assunto',
        'data_contato',
        'notas',
        'tipo_contato',
        'cliente_id',
        'filial_id',
    ];

    /**
     * Relação com o cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relação com a filial.
     */
    public function filial()
    {
        return $this->belongsTo(Filial::class);
    }
}
