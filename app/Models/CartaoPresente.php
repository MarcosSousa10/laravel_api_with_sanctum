<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartaoPresente extends Model
{
    use HasFactory;
    protected $table = 'cartoes_presente';

    protected $fillable = [
        'codigo',
        'data_emissao',
        'data_expiracao',
        'data_resgate',
        'status',
        'valor',
        'emitido_para_cliente_id',
        'resgatado_por_cliente_id',
    ];

    /**
     * Define a relação com o cliente que recebeu o cartão.
     */
    public function clienteEmitidoPara()
    {
        return $this->belongsTo(Cliente::class, 'emitido_para_cliente_id');
    }

    /**
     * Define a relação com o cliente que resgatou o cartão.
     */
    public function clienteResgatadoPor()
    {
        return $this->belongsTo(Cliente::class, 'resgatado_por_cliente_id');
    }
}
