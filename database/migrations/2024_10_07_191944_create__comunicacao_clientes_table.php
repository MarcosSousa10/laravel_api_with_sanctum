<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComunicacaoClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comunicacao_clientes', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->string('assunto', 100)->nullable(); // Assunto da comunicação
            $table->timestamp('created_at')->nullable(); // Data de criação
            $table->dateTime('data_contato'); // Data e hora do contato
            $table->text('notas')->nullable(); // Notas adicionais
            $table->string('tipo_contato'); // Tipo de contato
            $table->timestamp('updated_at')->nullable(); // Data de atualização
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade'); // Referência ao cliente
            $table->foreignId('filial_id')->constrained('filiais', 'filial_id'); // chave estrangeira referenciando 'filial_id'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comunicacao_clientes');
    }
}
