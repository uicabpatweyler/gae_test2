<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entradas', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          $table->string('serie');
          $table->string('folio');
          //1=Entrada por inventario inicial
          //2=Entrada por compra
          $table->unsignedInteger('tipo');
          $table->string('referencia');
          $table->date('fecha');
          $table->boolean('cancelado')->default(false);
          $table->unsignedInteger('user_created')->default(0);
          $table->unsignedInteger('user_updated')->default(0);
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
        Schema::dropIfExists('entradas');
    }
}
