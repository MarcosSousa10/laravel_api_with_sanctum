<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesempenhoDosFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desempenho_dos_funcionarios', function (Blueprint $table) {
            $table->id(); // Chave primária auto-incrementável
            $table->dateTime('created_at')->nullable(); // Data de criação
            $table->dateTime('data_registro'); // Data do registro
            $table->string('tipo_metrica', 100); // Tipo de métrica
            $table->dateTime('updated_at')->nullable(); // Data da última atualização
            $table->decimal('valor_metrica', 10, 2); // Valor da métrica
            $table->unsignedBigInteger('profissional_id'); // ID do profissional
            $table->primary('id'); // Define a chave primária
            $table->foreign('profissional_id', 'FKn7c7kpy6b9f0q5dermjxhyjhi')
                ->references('id')->on('profissionais') // Define a relação com a tabela `profissionais`
                ->onDelete('cascade'); // Cascata na exclusão
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desempenho_dos_funcionarios');
    }
}
