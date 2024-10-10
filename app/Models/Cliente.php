<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';

    protected $fillable = [
        'data_nascimento',
        'email',
        'endereco',
        'nome',
        'telefone',
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }
}
