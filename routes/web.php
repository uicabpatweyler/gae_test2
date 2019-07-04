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


Route::get('/', function () {
  return view('dashboard');
});


Route::prefix('config')->group(function () {
  Route::resource('escuelas', 'Config\EscuelaController');
  Route::resource('ciclos', 'Config\CicloController');
  Route::resource('grados', 'Config\GradoController');
  Route::resource('grupos', 'Config\GrupoController');
  Route::resource('cuotas', 'Config\CuotaController');
  Route::get('showapplypay/{cuota}', 'Config\CuotaGrupoController@show')->name('show.apply.pay');
  Route::post('cuotagrupo/{cuota}', 'Config\CuotaGrupoController@cuotaGrupo')->name('cuota.grupo');
});

Route::resource('alumnos','AlumnoController');

Route::get('alumno/direccion/{alumno}','InfoAlumnoController@createDireccion')
  ->name('alumno.direccion.create');
Route::post('alumno/direccion/store','InfoAlumnoController@storeDireccion')
  ->name('alumno.direccion.store');
Route::get('alumno/infoadicional/{informacionAlumno}','InfoAlumnoController@createInfoGral')
  ->name('alumno.infoadicional.create');
Route::patch('alumno/infoadicional/{informacionAlumno}', 'InfoAlumnoController@updateInfoGral')
  ->name('alumno.infoadicional.update');

Route::resource('tutores','TutorController');

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

Route::get('impresion/reciboinscripcion/{pagoInscripcion}/{inscripcion}', 'Impresion\ReciboInscripcion@printPDF')
  ->name('print.recibo.inscripcion');
Route::get('impresion/hojainscripcion/{inscripcion}', 'Impresion\HojaInscripcion@printPDF')
  ->name('print.hoja.inscripcion');

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
  Route::get('info_alumnos', 'DataController@infoAlumnos')->name('info.alumnos.data');
  Route::get('gruposinscripcion/{escuela}/{grado}/{ciclo}', 'DataController@gruposInscripcion')
    ->name('gruposinscr.data');
  Route::get('alumnos_data','DataController@alumnos')->name('alumnos.data');
});

Route::prefix('admin')->group(function () {
  Route::get('niveltipo/{tipo_id}', 'Admin\NivelController@niveltipo');
  Route::get('servnivel/{nivel_id}', 'Admin\ServicioController@servnivel');
});

//Ruta para la importacion de datos
Route::get('importAlumnos', 'ImportacionController@importAlumnos');
Route::get('importDatosPersonales', 'ImportacionController@importDatosPersonales');
Route::get('asignarTutor', 'ImportacionController@asignarTutor');
Route::get('importTutores', 'ImportacionController@importTutores');
Route::get('infoTutores', 'ImportacionController@infoTutores');
Route::get('importPagosInscripcion', 'ImportacionController@importPagosInscripcion');
Route::get('importInscripciones', 'ImportacionController@importInscripciones');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
