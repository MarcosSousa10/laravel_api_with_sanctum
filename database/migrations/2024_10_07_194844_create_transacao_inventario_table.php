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
            $table->bigInteger('inventario_id')->unsigned();
            $table->bigInteger('transacao_id')->unsigned();

            $table->primary(['inventario_id', 'transacao_id']);

            $table->foreign('inventario_id')->references('id')->on('inventario')->onDelete('cascade');
            $table->foreign('transacao_id')->references('id')->on('transacoes')->onDelete('cascade');
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
