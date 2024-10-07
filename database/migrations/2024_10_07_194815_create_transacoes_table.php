<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID da transação
            $table->dateTime('created_at')->nullable(); // Data de criação
            $table->dateTime('data_transacao'); // Data da transação
            $table->string('metodo_pagamento'); // Método de pagamento
            $table->dateTime('updated_at')->nullable(); // Data de atualização
            $table->decimal('valor_pago', 10, 2); // Valor pago
            $table->bigInteger('agendamento_id')->nullable()->unsigned(); // ID do agendamento (opcional)
            $table->bigInteger('filial_id')->unsigned(); // ID da filial

            // Chave primária
            $table->primary('id');

            // Chaves estrangeiras
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('set null'); // Chave estrangeira para agendamentos
            $table->foreign('filial_id')->references('filial_id')->on('filiais')->onDelete('cascade'); // Chave estrangeira para filiais
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
}
