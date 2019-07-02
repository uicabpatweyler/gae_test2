<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeriesFoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series_folios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('serie',10)->nullable();
            $table->unsignedInteger('folio');
            $table->unsignedInteger('tipo');
            $table->string('descripcion_',120)->nullable();
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
        Schema::dropIfExists('series_folios');
    }
}
