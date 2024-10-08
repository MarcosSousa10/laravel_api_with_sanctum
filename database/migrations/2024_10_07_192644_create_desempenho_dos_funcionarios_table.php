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
            $table->id();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('data_registro');
            $table->string('tipo_metrica', 100);
            $table->dateTime('updated_at')->nullable();
            $table->decimal('valor_metrica', 10, 2);
            $table->unsignedBigInteger('profissional_id');
            $table->primary('id');
            $table->foreign('profissional_id', 'FKn7c7kpy6b9f0q5dermjxhyjhi')
                ->references('id')->on('profissionais')
                ->onDelete('cascade'); 
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
