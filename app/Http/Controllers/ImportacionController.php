<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\InformacionAlumno;
use App\Models\InformacionTutor;
use App\Models\Inscripcion;
use App\Models\PagoInscripcion;
use App\Models\Tutor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportacionController extends Controller
{
    public function importAlumnos(){
      $rows = DB::table('alumnos2')->get();
      foreach ($rows as $row){
        //echo Carbon::create($row->created_at)->addHour(5).'***'.Carbon::create($row->updated_at)->addHour(5);
        //echo '<br/>';
        Alumno::create([
          'curp' => $row->alumno_curp,
          'nombre1' => $row->alumno_primernombre,
          'nombre2' => $row->alumno_segundonombre,
          'apellido1' => $row->alumno_apellidopaterno,
          'apellido2' => $row->alumno_apellidomaterno,
          'fechanacimiento' => $row->alumno_fechanacimiento,
          'genero' => $row->alumno_genero,
          'status' => true,
          'created_at' => Carbon::create($row->created_at)->addHour(5),
          'updated_at' => Carbon::create($row->updated_at)->addHour(5)
        ]);
        echo $row->id;
        echo '<br/>';
      }
      exit;
    }

    public function importDatosPersonales(){
      $rows = DB::table('datos_inscripcion_alumno')->get();
      foreach ($rows as $row){
        $aux = DB::table('alumnos_datospersonales')
          ->where('id','=', $row->datospersonales_id)
          ->first();

        InformacionAlumno::create([
          'escuela_id' => $row->escuela_id,
          'ciclo_id' => $row->ciclo_id,
          'alumno_id' => $row->alumno_id,
          'tutor_id' => 0,
          'nombre_vialidad' => $aux->nombre_vialidad,
          'exterior' => $aux->numero_exterior,
          'interior' => $aux->numero_interior,
          'entre_calles' => $aux->entre_calles,
          'tipo_asentamiento' => $aux->tipo_asentamiento,
          'nombre_asentamiento' => $aux->nombre_asentamiento,
          'codigo_postal' => $aux->codigo_postal,
          'localidad' => $aux->nombre_localidad,
          'delegacion' => $aux->delegacion_municipio,
          'estado' => $aux->entidad_federativa,
          'telefcasa' => $row->telefono_casa,
          'referencia1' => $row->referencia1,
          'teleftutor' => $row->telefono_tutor,
          'referencia2' => $row->referencia2,
          'telefcelular' => $row->telefono_celular,
          'referencia3' => $row->referencia3,
          'telefotro' => $row->telefono_otro,
          'referencia4' => $row->referencia4,
          'escuela' => $row->alumno_escuela,
          'ultimogrado' => $row->alumno_ultimogrado,
          'lugartrabajo' => $row->alumno_lugartrabajo,
          'email' => $row->alumno_email,
          'pregunta1' => $row->encuesta_pregunta1,
          'pregunta2' => $row->encuesta_pregunta2,
          'status' => true,
          'created_at' => Carbon::create($row->created_at)->addHour(5),
          'updated_at' => Carbon::create($row->updated_at)->addHour(5)
        ]);

      }

      exit();
    }

    public function asignarTutor(){
      $rows = DB::table('tutores_alumnos')->get();
      foreach ($rows as $row){
        InformacionAlumno::where('escuela_id', $row->escuela_id)
          ->where('ciclo_id', $row->ciclo_id)
          ->where('alumno_id',$row->alumno_id)
          ->update(['tutor_id' => $row->tutor_id]);
      }
    }

    public function importTutores(){
      $rows = DB::table('tutores2')->get();
      foreach ($rows as $row){
        Tutor::create([
          'nombre' => $row->tutor_nombre,
          'apellido1' => $row->tutor_apellidopaterno,
          'apellido2' => $row->tutor_apellidomaterno,
          'genero' => $row->tutor_genero,
          'status' => true,
          'created_at' => Carbon::create($row->created_at)->addHour(5),
          'updated_at' => Carbon::create($row->updated_at)->addHour(5)
        ]);
      }
    }

    public function infoTutores(){
      $rows = InformacionAlumno::all();
      foreach ($rows as $row){
        $infoTutor = DB::table('tutores_datospersonales')
        ->where('tutor_id','=', $row->tutor_id)
        ->first();
        InformacionTutor::create([
          'escuela_id' => $row->escuela_id,
          'ciclo_id' => $row->ciclo_id,
          'tutor_id' => $row->tutor_id,
          'alumno_id' => $row->alumno_id,
          'infoalumno_id' => $row->id,
          'nombre_vialidad' => $infoTutor->nombre_vialidad,
          'exterior' => $infoTutor->numero_exterior,
          'interior' => $infoTutor->numero_interior,
          'entre_calles' => $infoTutor->entre_calles,
          'tipo_asentamiento' => $infoTutor->tipo_asentamiento,
          'nombre_asentamiento' => $infoTutor->nombre_asentamiento,
          'codigo_postal' => $infoTutor->codigo_postal,
          'localidad' => $infoTutor->nombre_localidad,
          'delegacion' => $infoTutor->delegacion_municipio,
          'estado' => $infoTutor->entidad_federativa,
          'telefcasa' => $infoTutor->telefono_casa,
          'referencia1' => $infoTutor->referencia1,
          'teleftrabajo' => $infoTutor->telefono_trabajo,
          'referencia2' => $infoTutor->referencia2,
          'telefcelular' => $infoTutor->telefono_celular,
          'referencia3' => $infoTutor->referencia3,
          'telefotro' => $infoTutor->telefono_otro,
          'referencia4' => $infoTutor->referencia4,
          'adicional_trabajo' => $infoTutor->tutor_lugartrabajo,
          'adicional_direccion' => $infoTutor->tutor_direccion_lugartrabajo,
          'adicional_estado' => $infoTutor->estado_direccion_lugartrabajo,
          'adicional_delegacion' => $infoTutor->delegacion_direccion_lugartrabajo,
          'adicional_localidad' => $infoTutor->localidad_direccion_lugartrabajo,
          'adicional_tipoasentamiento' => null,
          'adicional_nombreasentamiento' => $infoTutor->colonia_direccion_lugartrabajo,
          'adicional_codpost' => $infoTutor->cp_direccion_lugartrabajo,
          'email' => $infoTutor->tutor_email,
          'status' => true,
          'created_at' => Carbon::create($infoTutor->created_at)->addHour(5),
          'updated_at' => Carbon::create($infoTutor->updated_at)->addHour(5)
        ]);
      }
    }

    public function importPagosInscripcion(){
      $rows = DB::table('pagos_inscripcion')->get();
      foreach($rows as $row){
        PagoInscripcion::create([
          'inscripcion_id' => $row->inscripcion_id,
          'escuela_id' => $row->escuela_id,
          'ciclo_id' => $row->ciclo_id,
          'grado_id' => $row->clasifgrupo_id,
          'grupo_id' => $row->grupo_id,
          'alumno_id' => $row->alumno_id,
          'user_created' => $row->user_id,
          'serie_recibo' => $row->serie_recibo,
          'folio_recibo' => $row->folio_recibo,
          'cantidad_concepto' => $row->cantidad_concepto,
          'importe_cuota' => $row->importe_cuota,
          'cantidad_recibida_mxn' => $row->cantidad_recibida_mxn,
          'fecha' => Carbon::create($row->created_at)->format('Y-m-d'),
          'status' => true,
          'created_at' => Carbon::create($row->created_at)->addHour(5),
          'updated_at' => Carbon::create($row->updated_at)->addHour(5)
        ]);
      }
    }

    public function importInscripciones(){
      $rows = DB::table('grupos_alumnos')->get();
      foreach ( $rows as $row) {
        Inscripcion::create([
          'escuela_id' => $row->escuela_id,
          'ciclo_id' => $row->ciclo_id,
          'grado_id' => $row->clasifgrupo_id,
          'grupo_id' => $row->grupo_id,
          'infoalumno_id' => $row->alumno_id,
          'alumno_id' => $row->alumno_id,
          'pago_id' => $row->alumno_id,
          'user_created' => $row->user_id,
          'fecha' => Carbon::create($row->created_at)->format('Y-m-d'),
          'created_at' => Carbon::create($row->created_at)->addHour(5),
          'updated_at' => Carbon::create($row->updated_at)->addHour(5)
        ]);
      }
    }

}
