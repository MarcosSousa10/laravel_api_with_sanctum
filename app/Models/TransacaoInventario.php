<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransacaoInventario extends Model
{
    use HasFactory;

    protected $table = 'transacao_inventario';

    public $timestamps = false; // Não usa timestamps padrão

    protected $fillable = [
        'inventario_id',
        'transacao_id',
    ];
}
