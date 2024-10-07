<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->text('descricao')->nullable(); // Descrição do produto (opcional)
            $table->string('nome_produto', 100); // Nome do produto (obrigatório)
            $table->decimal('preco', 10, 2); // Preço do produto (obrigatório)
            $table->integer('quantidade'); // Quantidade do produto (obrigatório)
            $table->dateTime('updated_at')->nullable(); // Data da última atualização (opcional)
            $table->bigInteger('filial_id')->unsigned(); // ID da filial (obrigatório)
            $table->bigInteger('fornecedor_id')->unsigned(); // ID do fornecedor (obrigatório)

            // Chaves primárias e estrangeiras
            $table->primary('id'); // Define a chave primária
            $table->foreign('filial_id')->references('filial_id')->on('filiais'); // Chave estrangeira para `filiais`
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores'); // Chave estrangeira para `fornecedores`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}
