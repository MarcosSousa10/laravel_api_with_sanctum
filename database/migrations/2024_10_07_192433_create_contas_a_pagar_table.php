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
            $table->id();
            $table->dateTime('created_at')->nullable();
            $table->date('data_pagamento')->nullable();
            $table->date('data_vencimento');
            $table->text('descricao')->nullable();
            $table->string('nome_fornecedor', 100);
            $table->string('status', 255);
            $table->dateTime('updated_at')->nullable();
            $table->decimal('valor', 10, 2);
            $table->unsignedBigInteger('filial_id');
            $table->primary('id');
            $table->foreign('filial_id', 'FKd9fs1pcc6eobiwink7133ieam')
                ->references('filial_id')->on('filiais')
                ->onDelete('cascade');
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
