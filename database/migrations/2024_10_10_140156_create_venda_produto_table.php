<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaProdutoTable extends Migration
{
    /**
     * Execute the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_produto', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária
            $table->foreignId('venda_id')->constrained()->onDelete('cascade'); // Referência à tabela 'vendas'
            $table->foreignId('inventario_id')->constrained('inventario')->onDelete('cascade'); // Referência à tabela 'inventario'
            $table->integer('quantidade'); // Coluna para armazenar a quantidade
            $table->decimal('preco_total', 10, 2); // Coluna para armazenar o preço total
            $table->timestamps(); // Colunas para armazenar created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_produto'); // Remove a tabela se existir
    }
}
