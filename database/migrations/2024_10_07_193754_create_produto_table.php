<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id('codprod'); // Chave primária auto-incrementável
            $table->string('descricao', 255)->nullable(); // Descrição do produto (opcional)
            $table->integer('estoquecd')->nullable(); // Estoque CD (opcional)
            $table->integer('estoquedispothon')->nullable(); // Estoque disponível Thon (opcional)
            $table->integer('estoqueothon')->nullable(); // Estoque Thon (opcional)
            $table->integer('giromes')->nullable(); // Giro mês (opcional)
            $table->string('produtopai', 255)->nullable(); // Produto pai (opcional)
            $table->integer('qtachegar')->nullable(); // Quantidade a chegar (opcional)
            $table->integer('qtvendida3meses')->nullable(); // Quantidade vendida nos últimos 3 meses (opcional)
            $table->string('unidade', 255)->nullable(); // Unidade de medida (opcional)

            // Chave primária
            $table->primary('codprod'); // Define a chave primária
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto');
    }
}
