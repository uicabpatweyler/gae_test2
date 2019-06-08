<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tipo_id');
            $table->unsignedBigInteger('nivel_id');
            $table->string('nombre',40);
            $table->boolean('status')->default(true);
            $table->softDeletes();
            $table->timestamps();

            //Relacion NIVELES:SERVICIOS-1:M
            $table->foreign('nivel_id')->references('id')->on('niveles');

            //Relacion TIPOS:SERVICIOS-1:M
            $table->foreign('tipo_id')->references('id')->on('tipos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
