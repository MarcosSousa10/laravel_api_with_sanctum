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
            $table->id();
            $table->dateTime('created_at')->nullable();
            $table->text('descricao')->nullable();
            $table->date('disponibilidade_inicio');
            $table->date('disponibilidade_fim');
            $table->string('nome_recompensa', 100);
            $table->integer('pontos_necessarios');
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('filial_id')->unsigned();

            $table->primary('id');
            $table->foreign('filial_id')->references('filial_id')->on('filiais');
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
