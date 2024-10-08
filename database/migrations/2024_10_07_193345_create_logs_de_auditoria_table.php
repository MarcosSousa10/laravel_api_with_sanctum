<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsDeAuditoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_de_auditoria', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->string('acao', 100); // Ação realizada (obrigatório)
            $table->dateTime('data_hora'); // Data e hora da ação (obrigatório)
            $table->text('detalhes')->nullable(); // Detalhes da ação (opcional)
            $table->string('endereco_ip', 45)->nullable(); // Endereço IP do usuário (opcional)
            $table->bigInteger('usuario_id')->unsigned()->nullable(); // ID do usuário (opcional)

            // Chaves primárias e estrangeiras
            $table->primary('id'); // Define a chave primária
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null'); // Chave estrangeira para `users`
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs_de_auditoria');
    }
}
