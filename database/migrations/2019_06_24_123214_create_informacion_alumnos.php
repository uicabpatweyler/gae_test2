<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformacionAlumnos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informacion_alumnos', function (Blueprint $table) {
          $table->bigIncrements('id');
          //Campos para la direccion del alumno
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
          //Campos para la informacion de contacto de los alumnos
          $table->string('telefcasa',30)->nullable();
          $table->string('referencia1',30)->nullable();
          $table->string('teleftutor',30)->nullable();
          $table->string('referencia2',30)->nullable();
          $table->string('telefcelular',30)->nullable();
          $table->string('referencia3',30)->nullable();
          $table->string('telefotro',30)->nullable();
          $table->string('referencia4',30)->nullable();
          //Campos informacion general de los alumnos
          $table->string('escuela',120)->nullable();
          $table->string('ultimogrado',120)->nullable();
          $table->string('lugartrabajo',120)->nullable();
          $table->string('email',60)->nullable();
          //Campos encuesta para el alumno
          $table->string('pregunta1',60)->nullable();
          $table->string('pregunta2',60)->nullable();
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
        Schema::dropIfExists('informacion_alumnos');
    }
}
