<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendaItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venda_item', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('quantidade');
            $table->bigInteger('inventario_id')->unsigned();
            $table->bigInteger('venda_id')->unsigned()->nullable();
            $table->primary('id');

            $table->foreign('inventario_id')->references('id')->on('inventario')->onDelete('cascade');
            $table->foreign('venda_id')->references('id')->on('vendas')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('venda_item');
    }
}
