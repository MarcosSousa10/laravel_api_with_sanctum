<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfissionaisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profissionais', function (Blueprint $table) {
            $table->id();
            $table->text('disponibilidade')->nullable();
            $table->string('email', 100)->unique();
            $table->string('especialidade', 100);
            $table->string('nome', 100)->unique();
            $table->decimal('taxa_comissao', 5, 2)->nullable();
            $table->string('telefone', 20);
            $table->foreignId('filial_id')->constrained('filiais', 'filial_id');
            $table->string('imagem')->nullable(); 
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
        Schema::dropIfExists('profissionais');
    }
}
