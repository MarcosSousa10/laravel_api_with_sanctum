
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacoesTable extends Migration
{
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('data_transacao');
            $table->string('metodo_pagamento');
            $table->decimal('valor_pago', 10, 2);
            $table->bigInteger('agendamento_id')->nullable()->unsigned();
            $table->bigInteger('venda_id')->nullable()->unsigned(); // Nova coluna para venda
            $table->bigInteger('filial_id')->unsigned();
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('set null');
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('set null'); // Nova referência para venda
            $table->foreign('filial_id')->references('filial_id')->on('filiais')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
}
