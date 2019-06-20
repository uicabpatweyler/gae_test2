<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDireccionesAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direcciones_alumnos', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('alumno_id');
          $table->string('nombre_vialidad',120);
          $table->string('exterior',40);
          $table->string('interior',40)->nullable();
          $table->string('entre_calles',120)->nullable();
          $table->string('tipo_asentamiento',60);
          $table->string('nombre_asentamiento',120);
          $table->string('codigo_postal',5);
          $table->string('localidad',40); //Chetumal
          $table->string('delegacion',40); //Othón P. Blanco
          $table->string('estado',24); //Quintana Roo
          $table->string('pais',20)->default('México');
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
        Schema::dropIfExists('direcciones_alumnos');
    }
}
