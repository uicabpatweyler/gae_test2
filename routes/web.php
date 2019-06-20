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
Route::get('direccion_alumno/create/{alumno}','DireccionController@direccionAlumnoCreate')
  ->name('direccion.alumno.create');

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
});

Route::prefix('admin')->group(function () {
  Route::get('niveltipo/{tipo_id}', 'Admin\NivelController@niveltipo');
  Route::get('servnivel/{nivel_id}', 'Admin\ServicioController@servnivel');
});
