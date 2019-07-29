<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Recursos:
https://laravel-news.com/navigating-a-new-laravel-codebase
https://laravel-news.com/authorization-gates
https://laravel-news.com/login-validation
*/

Route::get('/', 'HomeController@index');

Route::prefix('config')->middleware('auth')->group(function () {
  Route::resource('escuelas', 'Config\EscuelaController');
  Route::resource('ciclos', 'Config\CicloController');
  Route::resource('grados', 'Config\GradoController');
  Route::resource('grupos', 'Config\GrupoController');
  Route::resource('cuotas', 'Config\CuotaController');
  Route::resource('categorias','Config\CategoriaController');
  Route::resource('productos','ProductoController');
  Route::get('categoria/child/create/{parent_id}','Config\CategoriaController@createChild')
    ->name('categoria.child.create');
  Route::get('showapplypay/{cuota}', 'Config\CuotaGrupoController@show')->name('show.apply.pay');
  Route::post('cuotagrupo/{cuota}', 'Config\CuotaGrupoController@cuotaGrupo')->name('cuota.grupo');
});

Route::middleware(['auth'])->group(function(){

  Route::resource('alumnos','AlumnoController');
  //Rutas para editar la información de un alumno existente en el sistema
  Route::get('alumno/informacion/{informacionAlumno}', 'InfoAlumnoController@show')
    ->name('infoalumno.show');
  Route::get('/alumno/informacion/{informacionAlumno}/edit','InfoAlumnoController@edit')
    ->name('infoalumno.edit');
  Route::patch('alumno/informacion/update/{informacionAlumno}', 'InfoAlumnoController@updateInfoAlumno')
    ->name('infoalumno.update');

  //Rutas para la creación de la información de un  nuevo alumno (inscripcion)
  Route::get('alumno/direccion/{alumno}','InfoAlumnoController@createDireccion')
    ->name('alumno.direccion.create');
  Route::post('alumno/direccion/store','InfoAlumnoController@storeDireccion')
    ->name('alumno.direccion.store');
  Route::get('alumno/infoadicional/{informacionAlumno}','InfoAlumnoController@createInfoGral')
    ->name('alumno.infoadicional.create');
  Route::patch('alumno/infoadicional/{informacionAlumno}', 'InfoAlumnoController@updateInfoGral')
    ->name('alumno.infoadicional.update');

  Route::resource('tutores','TutorController')->except(['show', 'edit','update']);
  Route::get('tutores/{tutor}','TutorController@show')->name('tutores.show');
  Route::get('tutores/{tutor}/edit', 'TutorController@edit')->name('tutores.edit');
  Route::patch('tutores/{tutor}', 'TutorController@update')->name('tutores.update');

  Route::get('tutor/informacion/{informacionTutor}', 'InfoTutorController@show')
    ->name('infotutor.show');
  Route::get('tutor/informacion/{informacionTutor}/editdireccion', 'InfoTutorController@editDireccionTutor')
    ->name('infotutor.edit.direccion');
  Route::patch('tutor/direccion/update/{informacionTutor}','InfoTutorController@updateDireccionTutor')
    ->name('infotutor.update.direccion');
  Route::get('tutor/informacion/{informacionTutor}/editTelefonos','InfoTutorController@editTelefonos')
    ->name('infotutor.edit.telefonos');
  Route::patch('tutor/telefono/update/{informacionTutor}', 'InfoTutorController@updateInfoTelefonos')
    ->name('infotutor.update.telefonos');
  Route::get('tutor/informacion/{informacionTutor}/editInfoAdicional', 'InfoTutorController@editInfoAdicional')
    ->name('infotutor.edit.infoadicional');
  Route::patch('tutor/infoadicional/update/{informacionTutor}','InfoTutorController@patchInfoAdicional')
    ->name('infotutor.update.infoadicional');


  Route::get('tutor/elegir_alumno/{tutor}', 'AlumnoTutor@tutorElegirAlumno')
    ->name('tutor.elegir.alumno');
  Route::patch('asignar_tutor_alumno','AlumnoTutor@asignarTutorAlumno')
    ->name('asignar.tutor.alumno');
  Route::get('tutor/direccion/{informacionAlumno}', 'InfoTutorController@createDireccion')
    ->name('tutor.direccion.create');
  Route::post('tutor/direccion/store','InfoTutorController@storeDireccion')
    ->name('tutor.direccion.store');
  Route::get('tutor/telefonos/{informacionTutor}', 'InfoTutorController@createTelefonos')
    ->name('tutor.telefonos.create');
  Route::patch('tutor/telefonos/{informacionTutor}','InfoTutorController@updateTelefonos')
    ->name('tutor.telefonos.update');
  Route::get('tutor/infoadicional/{informacionTutor}', 'InfoTutorController@createInfoAdicional')
    ->name('tutor.infoadicional.create');
  Route::patch('tutor/infoadicional/{informacionTutor}', 'InfoTutorController@updateInfoAdicional')
    ->name('tutor.infoadicional.update');
  Route::resource('inscripciones', 'InscripcionController')->except(['create']);
  Route::get('inscripcion/create/{informacionAlumno}','InscripcionController@create')
    ->name('inscripcion.create');

  Route::get('reinscripciones', 'ReInscripcionController@index')->name('reinscripciones.index');
  Route::get('reinscripcion/selectciclo/{alumno}','ReInscripcionController@selectCiclo')
    ->name('reinscripcion.selectciclo');
  Route::get('reinscripcion/info_alumno/{alumno}/{informacionAlumno}', 'ReInscripcionController@createInfoAlumno')
    ->name('reinscripcion.infoalumno.create');
  Route::post('reinscripcion/info_alumno/store', 'ReInscripcionController@storeInfoAlumno')
    ->name('reinscripcion.infoalumno.store');

  Route::resource('pagos_inscripcion', 'PagoInscripcionController')->except(['create']);
  Route::get('inscripcion/pago/{inscripcion}', 'PagoInscripcionController@create')
    ->name('pagos_inscripcion.create');

  Route::get('pagocolegiaturas','PagoColegiaturaController@index')
    ->name('pagocolegiaturas.index');
  Route::get('pagocolegiaturas/create/{inscripcion}', 'PagoColegiaturaController@create')
    ->name('pagocolegiaturas.create');
  Route::post('pagocolegiaturas', 'PagoColegiaturaController@store')
    ->name('pgocolegiaturas.store');
  Route::get('pagocolegiaturas/show/cancel/{pagoColegiatura}', 'PagoColegiaturaController@showPayToCancel')
    ->name('pagocolegiaturas.showpaytocancel');
  Route::post('pagocolegiatura/cancel/{pagoColegiatura}','PagoColegiaturaController@cancelarPagoColegiatura')
    ->name('cancelar.pagocolegiatura');

  Route::get('pagocolegiaturas/faltantes', 'PagoColegiaturaController@alumnosDeudores')
    ->name('pagocolegiaturas.faltantes');

  Route::resource('ventas', 'VentaController');

  Route::get('impresion/reciboinscripcion/{pagoInscripcion}/{inscripcion}', 'Impresion\ReciboInscripcion@printPDF')
    ->name('print.recibo.inscripcion');
  Route::get('impresion/hojainscripcion/{inscripcion}', 'Impresion\HojaInscripcion@printPDF')
    ->name('print.hoja.inscripcion');
  Route::get('/impresion/recibocolegiatura/{pagoColegiatura}', 'Impresion\ReciboColegiatura@printPDF')
    ->name('print.recibo.colegiatura');
  Route::get('alumnos/impresion/hojainscripcion','ImpresionController@hojaInscripcion')
    ->name('alumnos.impresion.hojainscripcion');
  Route::get('alumnos/impresion/reciboinscripcion','ImpresionController@reciboInscripcion')
    ->name('alumnos.impresion.reciboinscripcion');
  Route::get('alumnos/impresion/recibocolegiatura','ImpresionController@reciboColegiatura')
    ->name('alumnos.impresion.recibocolegiatura');
  Route::get('impresion/inscripcionespordia','ImpresionController@listadoInscripciones')
    ->name('impresion.inscripcionespordia.listado');
  Route::get('impresion/inscripciongradogrupo', 'ImpresionController@inscripcionesGradoGrupo')
    ->name('impresion.inscripciongradogrupo.index');
  Route::get('impresion/kardex','ImpresionController@kardexProductos')
    ->name('impresion.kardex.productos');

  Route::get('reportes/colegiaturapordia/{fecha}','Reporte\PagosColegiaturaPorDia@printPDF');
  Route::get('reportes/inscripcionpordia/{fecha}', 'Reporte\PagosInscripcionPorDia@printPDF');

  Route::prefix('pdf')->group(function() {
    Route::get('inscripciones_escuela_ciclo/{escuela}/{ciclo}', 'Reporte\InscripcionesEscuelaCiclo@printPDF')
      ->name('pdf.inscripciones.escuela.ciclo');
    Route::get('kardex/{escuela}/{ciclo}/{categoria}','Reporte\Kardex@printPDF')
      ->name('pdf.kardex');
  });

  Route::prefix('data')->group(function () {
    Route::get('escuelas', 'DataController@escuelas')->name('escuelas.data');
    Route::get('ciclos', 'DataController@ciclos')->name('ciclos.data');
    Route::get('grados/{escuela}', 'DataController@grados')->name('grados.data');
    Route::get('selectgrados/{escuela}', 'DataController@selectGradosEscuela');
    Route::get('grupos/{escuela}/{grado}/{ciclo}', 'DataController@grupos');
    Route::get('cuotas/{escuela}/{ciclo}/{tipo}', 'DataController@cuotas')->name('cuotas.data');
    Route::get('_cuotas/{escuela}/{ciclo}/{tipo}', 'DataController@selectCuotas')->name('selectCuotas');
    Route::get('delegaciones/{estado}','DataController@selectDelegaciones')->name('selectDelegaciones');
    Route::get('colonias/{estado}/{delegacion}','DataController@selectColonias');
    Route::get('colonia/{colonia}','DataController@colonia');
    Route::get('tutores','DataController@tutores')->name('tutores.data');
    Route::get('gruposinscripcion/{escuela}/{grado}/{ciclo}', 'DataController@gruposInscripcion')
      ->name('gruposinscr.data');
    Route::get('pagos/colegiatura/porfecha/{fecha}','DataController@colegiaturasPorFecha')
      ->name('colegiaturasporfecha.data');
    Route::get('pagos/inscripcion/porfecha/{fecha}', 'DataController@inscripcionesPorFecha');
    Route::get('categorias','DataController@categorias')->name('categorias.data');
    Route::get('categorias/childs/{parent_id}','DataController@selectChilds')->name('childs.data');
    Route::get('productos/{escuela}/{ciclo}/{parent}/{parentid}','DataController@dtProductos')
      ->name('productos.data');

    //alumnos.index Alumnos
    Route::get('alumnos','DataController@indexAlumnos')->name('index.alumnos.data');

    //inscripciones.index Lista de alumnos para inscribir (los datos del alumno fueron creados durante la inscripción)
    Route::get('info_alumnos', 'DataController@infoAlumnos')->name('info.alumnos.data');

    //reinscripciones.index Lista de alumnos disponibles para reinscribir
    Route::get('alumnos_data','DataController@alumnos')->name('alumnos.data');

    //pagos.colegiatura.index
    Route::get('alumnos/{escuela}/{ciclo}', 'DataController@alumnosEscuelaCiclo')
      ->name('alumnos.escuela.ciclo.data');

  });

  Route::prefix('admin')->group(function () {
    Route::get('niveltipo/{tipo_id}', 'Admin\NivelController@niveltipo');
    Route::get('servnivel/{nivel_id}', 'Admin\ServicioController@servnivel');
  });

});

//Ruta para la importacion de datos
Route::get('importAlumnos', 'ImportacionController@importAlumnos');
Route::get('importDatosPersonales', 'ImportacionController@importDatosPersonales');
Route::get('asignarTutor', 'ImportacionController@asignarTutor');
Route::get('importTutores', 'ImportacionController@importTutores');
Route::get('infoTutores', 'ImportacionController@infoTutores');
Route::get('importPagosInscripcion', 'ImportacionController@importPagosInscripcion');
Route::get('importInscripciones', 'ImportacionController@importInscripciones');

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes(['register' => false, 'reset' => false]);
