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
            $table->id();
            $table->bigInteger('produto_id')->unsigned();
            $table->bigInteger('cliente_id')->unsigned();
            $table->bigInteger('profissional_id')->unsigned();
            $table->integer('quantidade');
            $table->decimal('preco_total', 10, 2);
            $table->dateTime('data_venda');
            $table->timestamps();

            // Relacionamentos
            $table->foreign('produto_id')->references('id')->on('inventario');
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->foreign('profissional_id')->references('id')->on('profissionais');
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

