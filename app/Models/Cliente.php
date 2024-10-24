<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'user_id', 
        'data_nascimento',
        'email',
        'endereco',
        'nome',
        'telefone',
        'pontos', 
    ];

    public function vendas()
    {
        return $this->hasMany(Venda::class);
    }

    // Função para adicionar pontos ao cliente
    public function adicionarPontos($valorGasto)
    {
        $pontosGanhos = $this->calcularPontos($valorGasto);
        $this->pontos += $pontosGanhos;
        $this->save();  // Salva as mudanças no banco de dados
    }

    // Função para calcular pontos com base no valor gasto
    public function calcularPontos($valor)
    {
        // Exemplo: a cada 1 real gasto, o cliente ganha 1 ponto.
        return floor($valor);
    }

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
