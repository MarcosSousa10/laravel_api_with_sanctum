<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreferenciasDosClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preferencias_dos_clientes', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação (opcional)
            $table->string('tipo_preferencia', 100); // Tipo de preferência (obrigatório)
            $table->dateTime('updated_at')->nullable(); // Data da última atualização (opcional)
            $table->text('valor_preferencia')->nullable(); // Valor da preferência (opcional)
            $table->bigInteger('cliente_id')->unsigned(); // ID do cliente (obrigatório)

            // Chaves primárias e estrangeiras
            $table->primary('id'); // Define a chave primária
            $table->foreign('cliente_id')->references('id')->on('clientes'); // Chave estrangeira para `clientes`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('preferencias_dos_clientes');
    }
}
