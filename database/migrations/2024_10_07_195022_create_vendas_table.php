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
            $table->bigIncrements('id');
            $table->dateTime('data_venda');
            $table->string('metodo_pagamento');
            $table->decimal('valor_total', 38, 2);
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('filial_id')->unsigned();
            $table->bigInteger('profissional_id')->unsigned();

            $table->primary('id');

            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('filial_id')->references('filial_id')->on('filiais')->onDelete('cascade');
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
