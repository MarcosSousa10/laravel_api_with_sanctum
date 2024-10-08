<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromocoesAtivasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promocoes_ativas', function (Blueprint $table) {
            $table->id();
            $table->dateTime('created_at')->nullable();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->decimal('desconto', 38, 2);
            $table->string('nome', 100);
            $table->string('descricao', 255)->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->bigInteger('filial_id')->unsigned();

            $table->primary('id');
            $table->foreign('filial_id')->references('filial_id')->on('filiais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promocoes_ativas');
    }
}
