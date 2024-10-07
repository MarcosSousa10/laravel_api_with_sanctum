<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDeContato extends Model
{
    use HasFactory;
    protected $table = 'agendas_de_contatos';

    protected $fillable = [
        'nome',
        'criterios',
        'descricao',
    ];
}
