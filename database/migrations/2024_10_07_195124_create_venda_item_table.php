<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_item', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID do item de venda
            $table->integer('quantidade'); // Quantidade do item (obrigatório)
            $table->bigInteger('inventario_id')->unsigned(); // ID do inventário (obrigatório)
            $table->bigInteger('venda_id')->unsigned()->nullable(); // ID da venda (opcional)

            // Chave primária
            $table->primary('id');

            // Chaves estrangeiras
            $table->foreign('inventario_id')->references('id')->on('inventario')->onDelete('cascade'); // Chave estrangeira para inventário
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade'); // Chave estrangeira para vendas
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_item');
    }
}
