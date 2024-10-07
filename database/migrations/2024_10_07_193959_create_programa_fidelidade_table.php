<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramaFidelidadeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programa_fidelidade', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->text('descricao')->nullable(); // Descrição do programa (opcional)
            $table->date('disponibilidade_inicio'); // Data de início da disponibilidade (obrigatório)
            $table->date('disponibilidade_fim'); // Data de fim da disponibilidade (obrigatório)
            $table->string('nome_recompensa', 100); // Nome da recompensa (obrigatório)
            $table->integer('pontos_necessarios'); // Pontos necessários para a recompensa (obrigatório)
            $table->dateTime('updated_at')->nullable(); // Data da última atualização (opcional)
            $table->bigInteger('filial_id')->unsigned(); // ID da filial (obrigatório)

            // Chaves primárias e estrangeiras
            $table->primary('id'); // Define a chave primária
            $table->foreign('filial_id')->references('filial_id')->on('filiais'); // Chave estrangeira para `filiais`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('programa_fidelidade');
    }
}
