<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContasAPagarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contas_a_pagar', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação
            $table->date('data_pagamento')->nullable(); // Data de pagamento
            $table->date('data_vencimento'); // Data de vencimento
            $table->text('descricao')->nullable(); // Descrição da conta a pagar
            $table->string('nome_fornecedor', 100); // Nome do fornecedor
            $table->string('status', 255); // Status da conta a pagar
            $table->dateTime('updated_at')->nullable(); // Data da última atualização
            $table->decimal('valor', 10, 2); // Valor da conta a pagar
            $table->unsignedBigInteger('filial_id'); // ID da filial
            $table->primary('id'); // Define a chave primária
            $table->foreign('filial_id', 'FKd9fs1pcc6eobiwink7133ieam')
                ->references('filial_id')->on('filiais') // Define a relação com a tabela `filiais`
                ->onDelete('cascade'); // Cascata na exclusão
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas_a_pagar');
    }
}
