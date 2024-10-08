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
            $table->id();
            $table->string('chave_configuracao', 100);
            $table->text('descricao')->nullable();
            $table->dateTime('ultima_atualizacao');
            $table->text('valor_configuracao');
            $table->unique('chave_configuracao'); 
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
