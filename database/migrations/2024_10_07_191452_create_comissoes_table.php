<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissoes', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->foreignId('agendamento_id')->constrained('agendamentos')->onDelete('cascade'); // Referência ao agendamento
            $table->timestamp('created_at')->useCurrent(); // Data de criação
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('cascade'); // Referência ao profissional
            $table->decimal('taxa_comissao', 5, 2); // Taxa de comissão
            $table->timestamp('updated_at')->nullable(); // Data de atualização (opcional)
            $table->decimal('valor_comissao', 10, 2); // Valor da comissão
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comissoes');
    }
}
