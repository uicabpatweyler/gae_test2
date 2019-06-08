<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('escuela_id');
            $table->unsignedBigInteger('ciclo_id');
            $table->string('nombre',120);
            $table->string('abreviacion',60)->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();

            //$table->unique(['ciclo_id','escuela_id','nombre'], 'grado_unico');

            $table->foreign('escuela_id')->references('id')->on('escuelas');
            $table->foreign('ciclo_id')->references('id')->on('ciclos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grados');
    }
}
