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
            $table->id();
            $table->foreignId('agendamento_id')->nullable()->constrained('agendamentos')->onDelete('cascade'); // Permitir nulo
            $table->foreignId('venda_id')->nullable()->constrained('vendas')->onDelete('cascade'); // Adicionando venda_id
            $table->timestamp('created_at')->useCurrent();
            $table->foreignId('profissional_id')->constrained('profissionais')->onDelete('cascade');
            $table->decimal('taxa_comissao', 5, 2);
            $table->timestamp('updated_at')->nullable();
            $table->decimal('valor_comissao', 10, 2);
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
