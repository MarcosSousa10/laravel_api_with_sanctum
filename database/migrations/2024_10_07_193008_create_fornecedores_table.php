<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->string('contato', 100)->nullable(); // Contato do fornecedor (opcional)
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->string('email', 100)->nullable(); // E-mail do fornecedor (opcional)
            $table->string('endereco', 255)->nullable(); // Endereço do fornecedor (opcional)
            $table->string('nome_fornecedor', 100); // Nome do fornecedor (obrigatório)
            $table->text('notas')->nullable(); // Notas sobre o fornecedor (opcional)
            $table->string('telefone', 20)->nullable(); // Telefone do fornecedor (opcional)
            $table->dateTime('updated_at')->nullable(); // Data da última atualização (opcional)
            $table->primary('id'); // Define a chave primária
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
