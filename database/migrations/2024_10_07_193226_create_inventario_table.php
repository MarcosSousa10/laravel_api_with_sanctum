<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario', function (Blueprint $table) {
            $table->id(); 
            $table->dateTime('created_at')->nullable();
            $table->text('descricao')->nullable();
            $table->string('nome_produto', 100);
            $table->decimal('preco', 10, 2);
            $table->integer('quantidade');
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('filial_id')->unsigned();
            $table->bigInteger('fornecedor_id')->unsigned();

            $table->primary('id');
            $table->foreign('filial_id')->references('filial_id')->on('filiais');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventario');
    }
}
