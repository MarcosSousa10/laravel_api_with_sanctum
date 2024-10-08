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
            $table->id();
            $table->dateTime('created_at')->nullable();
            $table->string('tipo_preferencia', 100);
            $table->dateTime('updated_at')->nullable();
            $table->text('valor_preferencia')->nullable();
            $table->bigInteger('cliente_id')->unsigned();

            $table->primary('id');
            $table->foreign('cliente_id')->references('id')->on('clientes'); 
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
