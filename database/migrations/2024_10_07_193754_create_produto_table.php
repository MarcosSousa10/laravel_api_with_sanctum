<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto', function (Blueprint $table) {
            $table->id('codprod');
            $table->string('descricao', 255)->nullable();
            $table->integer('estoquecd')->nullable();
            $table->integer('estoquedispothon')->nullable();
            $table->integer('estoqueothon')->nullable();
            $table->integer('giromes')->nullable();
            $table->string('produtopai', 255)->nullable();
            $table->integer('qtachegar')->nullable();
            $table->integer('qtvendida3meses')->nullable();
            $table->string('unidade', 255)->nullable();
            $table->primary('codprod');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto');
    }
}
