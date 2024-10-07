<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocoesAtivasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocoes_ativas', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->date('data_inicio'); // Data de início da promoção (obrigatório)
            $table->date('data_fim'); // Data de fim da promoção (obrigatório)
            $table->decimal('desconto', 38, 2); // Valor do desconto (obrigatório)
            $table->string('nome', 100); // Nome da promoção (obrigatório)
            $table->string('descricao', 255)->nullable(); // Descrição da promoção (opcional)
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
        Schema::dropIfExists('promocoes_ativas');
    }
}
