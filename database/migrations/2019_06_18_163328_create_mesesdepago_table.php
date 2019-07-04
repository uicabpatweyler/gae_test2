<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMesesdepagoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesesdepago', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('cuota_id');
          $table->tinyInteger('orden');
          $table->string('mes',10);
          $table->date('fecha1');
          $table->date('fecha2');
          $table->date('fecha3');
          $table->date('fecha4');
          $table->double('recargo',8,2);
          $table->double('descuento',8,2);
          $table->boolean('status')->default(true);
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
        Schema::dropIfExists('mesesdepago');
    }
}
