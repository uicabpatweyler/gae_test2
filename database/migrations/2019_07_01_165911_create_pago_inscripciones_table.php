<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagoInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pago_inscripciones', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->unsignedBigInteger('inscripcion_id')->unique();
          $table->unsignedBigInteger('escuela_id');
          $table->unsignedBigInteger('ciclo_id');
          $table->unsignedBigInteger('grado_id');
          $table->unsignedBigInteger('grupo_id');
          $table->unsignedBigInteger('alumno_id');
          $table->unsignedBigInteger('user_id')->default(0);

          $table->string('serie_recibo',10)->nullable();
          $table->unsignedBigInteger('folio_recibo')->unsigned();
          $table->float('cantidad_concepto'); //1
          $table->float('importe_cuota'); //450.00
          $table->float('porcentaje_descuento')->default(0); //0
          $table->float('descuento_pesos')->default(0); //0
          $table->string('moneda',10)->default('MXN'); //MXN Peso Mexicano - USD Dolar Americano
          $table->float('cantidad_recibida_mxn'); //Lo que se recibe del cliente en MXN
          $table->float('cantidad_recibida_usd')->default(0); //Lo que se recibe del cliente en Dolares
          $table->float('usd_tipodecambio')->default(0);
          $table->string('forma_de_pago',4)->default('01'); //01-Efectivo, 04-Tarjeta de crédito, 48 - Tarjeta de débito
          $table->string('referencia_pago')->nullable(); //Para los pagos con TDC o TDD
          $table->string('tipo_tarjeta',20)->nullable(); //Visa o MasterCard
          $table->boolean('pago_cancelado')->default(false);
          $table->dateTime('fecha_cancelacion')->nullable();
          $table->integer('cancelado_por')->default(0);
          $table->string('motivo_cancelacion')->nullable();
          $table->boolean('status')->default(true);
          $table->date('fecha');
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
        Schema::dropIfExists('pago_inscripciones');
    }
}
