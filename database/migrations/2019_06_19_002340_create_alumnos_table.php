<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('curp',25)->unique();
          $table->string('nombre1',60);
          $table->string('nombre2',60)->nullable();
          $table->string('apellido1',60);
          $table->string('apellido2',60)->nullable();
          $table->date('fechanacimiento');
          $table->char('genero',1);
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
        Schema::dropIfExists('alumnos');
    }
}
