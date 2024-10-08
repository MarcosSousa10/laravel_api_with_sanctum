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
            $table->id();
            $table->text('conteudo_template')->nullable(); 
            $table->dateTime('created_at')->nullable();
            $table->string('nome_template', 100);
            $table->string('tipo_template', 255);
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
        Schema::dropIfExists('templates_de_notificacoes');
    }
}
