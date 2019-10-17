<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKardexTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardex', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          $table->unsignedBigInteger('producto_id');
          $table->double('inicial')->default(0);
          $table->double('entradas')->default(0);
          $table->double('salidas')->default(0);
          $table->double('existencia')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kardex');
    }
}
