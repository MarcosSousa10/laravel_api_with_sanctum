<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->dateTime('data_hora_agendamento');
            $table->text('notas')->nullable();
            $table->decimal('preco_total', 10, 2)->nullable();
            $table->string('status', 255);
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->foreignId('filial_id')->constrained('filiais', 'filial_id');
            $table->foreignId('profissional_id')->constrained('profissionais');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
