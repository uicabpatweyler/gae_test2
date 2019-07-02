<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          $table->unsignedBigInteger('grado_id');
          $table->unsignedBigInteger('grupo_id');
          $table->unsignedBigInteger('infoalumno_id');
          $table->unsignedBigInteger('alumno_id');
          $table->unsignedBigInteger('pago_id')->default(0);
          $table->unsignedBigInteger('baja_id')->default(0);
          $table->unsignedBigInteger('becario_id')->default(0);
          $table->unsignedBigInteger('user_id')->default(0);
          $table->date('fecha');
          $table->boolean('status')->default(true);
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
        Schema::dropIfExists('inscripciones');
    }
}
