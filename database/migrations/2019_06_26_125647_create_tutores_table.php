<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTutoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutores', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('nombre',60);
          $table->string('apellido1',60);
          $table->string('apellido2',60)->nullable();
          $table->char('genero',1);
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
        Schema::dropIfExists('tutores');
    }
}
