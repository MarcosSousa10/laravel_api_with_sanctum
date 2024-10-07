<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartoesPresenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoes_presente', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 100)->unique();
            $table->date('data_emissao');
            $table->date('data_expiracao');
            $table->date('data_resgate')->nullable();
            $table->string('status', 255);
            $table->decimal('valor', 38, 2);
            $table->foreignId('emitido_para_cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
            $table->foreignId('resgatado_por_cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
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
        Schema::dropIfExists('cartoes_presente');
    }
}
