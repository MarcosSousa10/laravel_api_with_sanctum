<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class VendaProduto extends Pivot
{
    protected $table = 'venda_produto'; // Certifique-se de que este é o nome correto da tabela
}
