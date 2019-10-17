<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradaItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entrada_items', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('entrada_id');
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          //1=Entrada por inventario inicial
          //2=Entrada por compra
          $table->unsignedInteger('tipo')->default(0);
          $table->unsignedInteger('linea');
          $table->unsignedBigInteger('producto_id');
          $table->double('cantidad');
          $table->boolean('cancelado')->default(false);
          $table->date('fecha');
          $table->softDeletes();
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
        Schema::dropIfExists('entrada_items');
    }
}
