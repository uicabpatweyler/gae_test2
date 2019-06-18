<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('escuela_id');
            $table->unsignedBigInteger('ciclo_id');
            $table->string('nombre',120);
            $table->integer('tipo')->default(0); //inscripcion=1, colegiatura=2
            $table->double('cantidad',8,2);
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();

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
        Schema::dropIfExists('cuotas');
    }
}
