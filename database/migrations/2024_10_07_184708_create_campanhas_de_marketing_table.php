<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampanhasDeMarketingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanhas_de_marketing', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->text('descricao')->nullable();
            $table->decimal('orçamento', 10, 2)->nullable();
            $table->string('status', 255);
            $table->foreignId('filial_id')->constrained('filiais', 'filial_id'); 
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
        Schema::dropIfExists('campanhas_de_marketing');
    }
}
