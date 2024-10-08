<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferenciasDosClientes extends Model
{
    use HasFactory;

    protected $table = 'preferencias_dos_clientes';

    protected $fillable = [
        'tipo_preferencia',
        'valor_preferencia',
        'cliente_id',
    ];

    public $timestamps = true; // Usar timestamps padrão do Laravel

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
