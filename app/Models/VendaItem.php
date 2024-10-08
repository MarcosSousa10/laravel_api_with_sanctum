<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendaItem extends Model
{
    use HasFactory;

    protected $table = 'venda_item'; // Define a tabela associada

    protected $fillable = [
        'quantidade',
        'inventario_id',
        'venda_id',
    ];

    // Relacionamentos
    public function inventario()
    {
        return $this->belongsTo(Inventario::class, 'inventario_id');
    }

    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }
}
