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
//Rutas para un usuario no autenticado
Route::group(['middleware' => ['guest']], function () {
    //Ruta para mostrar el formulario para iniciar sesion
    Route::get('/','Auth\LoginController@showLoginForm');
    //Ruta para iniciar sesion
    Route::post('/login','Auth\LoginController@login')->name('login');
});
//Rutas para un usuario autenticado
Route::group(['middleware' => ['auth']], function () {
    //Rutas para el usuario 'Administrador'
    Route::group(['middleware' => ['Administrador']], function () {
        //Rutas para ver y listar roles
        Route::get('/rol','RolController@index');
        Route::get('/rol/selectRol','RolController@selectRol');
        //Rutas para ver, agregar, actualizar, listar y activar/desactivar usuarios
        Route::get('/usuario','UserController@index');
        Route::post('/usuario/registrar','UserController@store');
        Route::put('/usuario/actualizar','UserController@update');
        Route::put('/usuario/desactivar','UserController@desactivar');
        Route::put('/usuario/activar','UserController@activar');
      //futas para proyectos
        Route::get('/usuario/selectCliente','UserController@selectCliente');
        Route::get('/usuario/selectManager','UserController@selectManager');
        Route::get('/usuario/selectProgramador','UserController@selectProgramador');
        Route::get('/proyecto','ProyectoController@index');
        Route::put('/proyecto/actualizar','ProyectoController@update');
        Route::put('/proyecto/desactivar','ProyectoController@desactivar');
        Route::post('/proyecto/registrar','ProyectoController@store');
        Route::put('/proyecto/cancelar','ProyectoController@cancelar');

        Route::get('/proyecto/proyectoprogramador','ProyectoController@proyectosProgramador');
        Route::get('/proyecto/proyectomanager','ProyectoController@proyectosManager');
        Route::get('/proyecto/proyectocliente','ProyectoController@proyectosCliente');

        Route::get('/miembros/proyectos','ProyectoMiembroController@index2');
        //rutas para metodos de pago
        Route::get('/metodoPago','MetodoPagoController@index');
        Route::post('/metodoPago/registrar','MetodoPagoController@store');
        Route::put('/metodoPago/actualizar','MetodoPagoController@update');
        Route::put('/metodoPago/desactivar','MetodoPagoController@desactivar');
        Route::put('/metodoPago/activar','MetodoPagoController@activar');
        

    });
    //Rutas para el usuario 'Director de Proyecto'
        Route::group(['middleware' => ['DirectorProyecto']], function () 
        {
            Route::get('/proyecto/proyectomanager','ProyectoController@proyectosManager');
            Route::put('/proyecto/desactivar','ProyectoController@desactivar');
            Route::get('/usuario/selectProgramador','UserController@selectProgramador');
            Route::get('/usuario/selectProyecto','ProyectoController@selectProyecto');
            Route::get('/usuario/selectHito','HitoController@selectHito');
            Route::get('/usuario/selectProgramadorTarea','UserController@selectProgramadorTarea');
            Route::post('/miembrosProyecto/agregar','ProyectoMiembroController@store');
            Route::get('/miembrosProyecto','ProyectoMiembroController@index');
            Route::post('/hito/registrar','HitoController@store');
            Route::put('/hito/actualizar','HitoController@update');
            Route::get('/hito','HitoController@index');
            Route::post('/hito/desactivar','HitoController@desactivar');
            Route::get('/tarea','TareaController@index');
            Route::post('/tarea/registrar','TareaController@store');
            Route::put('/tarea/desactivar','TareaController@desactivar');
            
    });
    //Rutas para el usuario 'Programador'
    Route::group(['middleware' => ['Programador']], function () {

Route::get('/proyecto/proyectoprogramador','ProyectoController@proyectosProgramador');
    });
    //Rutas para el usuario 'Cliente'
    Route::group(['middleware' => ['Cliente']], function () {
      Route::get('/proyecto/proyectocliente','ProyectoController@proyectosCliente');
      Route::put('/proyecto/cancelar','ProyectoController@cancelar');
    });
    //Contenido principal
    Route::get('/principal', function () {
        return view('contenido/contenido');
    })->name('principal');
    //Ruta para cerrar sesion
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
});

