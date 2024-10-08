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
            $table->bigIncrements('id');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('data_transacao');
            $table->string('metodo_pagamento');
            $table->dateTime('updated_at')->nullable();
            $table->decimal('valor_pago', 10, 2);
            $table->bigInteger('agendamento_id')->nullable()->unsigned();
            $table->bigInteger('filial_id')->unsigned();

            $table->primary('id');

            $table->foreign('agendamento_id')->references('id')->on('agendamentos')->onDelete('set null'); 
            $table->foreign('filial_id')->references('filial_id')->on('filiais')->onDelete('cascade');
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
