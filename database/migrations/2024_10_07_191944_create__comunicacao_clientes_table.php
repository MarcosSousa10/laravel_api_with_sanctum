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
            $table->id();
            $table->string('assunto', 100)->nullable();
            $table->timestamp('created_at')->nullable();
            $table->dateTime('data_contato');
            $table->text('notas')->nullable();
            $table->string('tipo_contato');
            $table->timestamp('updated_at')->nullable();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('filial_id')->constrained('filiais', 'filial_id'); 
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
