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
            $table->bigIncrements('id'); // ID da venda
            $table->dateTime('data_venda'); // Data da venda (obrigatório)
            $table->string('metodo_pagamento'); // Método de pagamento (obrigatório)
            $table->decimal('valor_total', 38, 2); // Valor total da venda (obrigatório)
            $table->bigInteger('cliente_id')->unsigned(); // ID do cliente (obrigatório)
            $table->bigInteger('filial_id')->unsigned(); // ID da filial (obrigatório)
            $table->bigInteger('profissional_id')->unsigned(); // ID do profissional (obrigatório)

            // Chave primária
            $table->primary('id');

            // Chaves estrangeiras
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade'); // Chave estrangeira para clientes
            $table->foreign('filial_id')->references('filial_id')->on('filiais')->onDelete('cascade'); // Chave estrangeira para filiais
            $table->foreign('profissional_id')->references('id')->on('profissionais')->onDelete('cascade'); // Chave estrangeira para profissionais
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
