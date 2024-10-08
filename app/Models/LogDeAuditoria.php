<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogDeAuditoria extends Model
{
    use HasFactory;

    protected $table = 'logs_de_auditoria';

    protected $fillable = [
        'acao',
        'data_hora',
        'detalhes',
        'endereco_ip',
        'usuario_id',
    ];

    public $timestamps = false; // Não usar timestamps padrão do Laravel

    protected $dates = [
        'data_hora',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
