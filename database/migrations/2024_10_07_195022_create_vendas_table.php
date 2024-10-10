<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('profissional_id')->unsigned();
            $table->decimal('preco_total', 10, 2)->default(0); // Preço total inicializado como 0
            $table->dateTime('data_venda'); // Data da venda
            $table->timestamps(); // Colunas created_at e updated_at

            // Relacionamentos
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('profissional_id')->references('id')->on('profissionais')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
