<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTemplatesDeNotificacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('templates_de_notificacoes', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->text('conteudo_template')->nullable(); // Conteúdo do template (opcional)
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->string('nome_template', 100); // Nome do template (obrigatório)
            $table->string('tipo_template', 255); // Tipo do template (obrigatório)
            $table->dateTime('updated_at')->nullable(); // Data da última atualização (opcional)

            // Chave primária
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
        Schema::dropIfExists('templates_de_notificacoes');
    }
}
