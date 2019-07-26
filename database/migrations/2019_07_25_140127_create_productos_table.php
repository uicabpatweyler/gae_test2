<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          $table->unsignedBigInteger('categoria_id');
          $table->unsignedBigInteger('subcategoria_id');
          $table->unsignedBigInteger('clasificacion1_id');
          $table->string('nombre_categoria');
          $table->string('codigo')->nullable();
          $table->string('nombre');
          $table->string('adicional')->nullable();
          $table->float('precio_venta')->default(0);
          $table->boolean('disponible')->default(true);
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
        Schema::dropIfExists('productos');
    }
}
