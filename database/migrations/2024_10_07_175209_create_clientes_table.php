<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Execute the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->date('data_nascimento');
            $table->string('email', 100)->unique();
            $table->string('endereco', 255)->nullable();
            $table->string('nome', 100)->unique();
            $table->string('telefone', 20);
            $table->integer('pontos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverte as migrações.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
