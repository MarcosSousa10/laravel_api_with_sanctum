<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransacaoInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transacao_inventario', function (Blueprint $table) {
            $table->bigInteger('inventario_id')->unsigned(); // ID do inventário (obrigatório)
            $table->bigInteger('transacao_id')->unsigned(); // ID da transação (obrigatório)

            // Chave primária composta
            $table->primary(['inventario_id', 'transacao_id']);

            // Chaves estrangeiras
            $table->foreign('inventario_id')->references('id')->on('inventario')->onDelete('cascade'); // Chave estrangeira para `inventario`
            $table->foreign('transacao_id')->references('id')->on('transacoes')->onDelete('cascade'); // Chave estrangeira para `transacoes`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transacao_inventario');
    }
}
