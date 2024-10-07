<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracoesDoSistemaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracoes_do_sistema', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->string('chave_configuracao', 100); // Chave da configuração
            $table->text('descricao')->nullable(); // Descrição da configuração
            $table->dateTime('ultima_atualizacao'); // Data da última atualização
            $table->text('valor_configuracao'); // Valor da configuração
            $table->unique('chave_configuracao'); // Restrição de unicidade para chave_configuracao
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracoes_do_sistema');
    }
}
