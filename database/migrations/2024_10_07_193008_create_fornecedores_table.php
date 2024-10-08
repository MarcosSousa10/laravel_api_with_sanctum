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
            $table->id();
            $table->string('contato', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('endereco', 255)->nullable();
            $table->string('nome_fornecedor', 100);
            $table->text('notas')->nullable();
            $table->string('telefone', 20)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->primary('id');
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
