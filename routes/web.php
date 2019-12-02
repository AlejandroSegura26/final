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
  //Contenido principal
  Route::get('/principal', function () {
    return view('contenido/contenido');
  })->name('principal');
  //Ruta para cerrar sesion
  Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
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

        //aceptar
        Route::get('/retiro','GastosController@vistaaprobar');
        Route::put('/retiro/aceptar','GastosController@aceptar');
        Route::put('/retiro/rechazar','GastosController@rechazar');
        Route::put('/retiro/cambio','GastosController@change');
        Route::get('/problema/problemasadmin','ProblemaController@problemasAdmin'); 
        Route::get('/usuario/selectProgramador','UserController@selectProgramador');
        Route::put('/problema/asignarProgramador','ProblemaController@asignarProgramador');
      
      //inbox general
      Route::get('/inbox','inboxController@inboxGeneral');
      Route::post('/inbox/enviar','inboxController@inboxNew');
      
      //servicios
      Route::get('/proyecto/admin','ProyectoController@selectProyectoAdmin');
      Route::get('/servicios','servicioController@index');
       Route::put('/servicios/activar','serviciosController@activar');
      Route::put('/servicios/desactivar','serviciosController@cancelar');
      Route::post('/servicios/agregar','serviciosController@store');
       Route::post('/servicios/proyecto','serviciosController@add');
        Route::get('/servicios/proyectos','serviciosController@index2');
    });
    //Rutas para el usuario 'Director de Proyecto'
    Route::group(['middleware' => ['DirectorProyecto']], function () {
      Route::get('/proyecto/proyectomanager','ProyectoController@proyectosManager');
      Route::put('/proyecto/desactivar','ProyectoController@desactivar');
      Route::get('/usuario/selectProgramador','UserController@selectProgramador');
      Route::get('/usuario/selectProyecto','ProyectoController@selectProyecto2');
      Route::get('/usuario/selectProgramadorTarea','UserController@selectProgramadorTarea');
      Route::get('/usuario/selectHito','HitoController@selectHito');
      Route::post('/miembrosProyecto/agregar','ProyectoMiembroController@store');
      Route::get('/miembrosProyecto','ProyectoMiembroController@index');
      Route::get('/retiro/programador','GastosController@index');
      Route::post('/retiro/agregar','GastosController@store');
      Route::get('/metodo/selectMetodoPago','MetodoPagoController@selectMetodoPago');
      Route::get('/proyecto/selectProyectoManager','ProyectoController@selectProyectoManager');
      Route::post('/hito/registrar','HitoController@store');
      Route::put('/hito/actualizar','HitoController@update');
      Route::get('/hito','HitoController@index');
      Route::post('/hito/desactivar','HitoController@desactivar');
      Route::get('/tarea','TareaController@index');
      Route::post('/tarea/registrar','TareaController@store');
      Route::put('/tarea/desactivar','TareaController@desactivar');
      Route::get('/problema','ProblemaController@index');
      Route::post('/problema/registrar','ProblemaController@store');
      Route::get('/usuario/selectProyecto','ProyectoController@selectProyecto');
      Route::put('/problema/asignarProgramador','ProblemaController@asignarProgramador');

      Route::get('/sitio', 'SitioController@index');
      Route::get('/site', 'SitioController@listarInfoSitios');
      Route::post('/site/registrar', 'SitioController@store');
      
      //servicios
      Route::get('/servicios','serviciosController@index');
      Route::post('/servicios/proyecto','serviciosController@add');
      //inbox manager
      Route::get('/manager/receptor','inboxController@inboxManagerR');
     
      Route::post('/inbox/enviar','inboxController@inboxNew');
      
      Route::get('/inbox/proyectom','inboxController@ProyectoM');
      Route::get('/inbox/cliente','inboxController@Clientes');
      

    });
    //Rutas para el usuario 'Programador'
    Route::group(['middleware' => ['Programador']], function () {
      Route::get('/retiro/programador','GastosController@index');
      Route::post('/retiro/agregar','GastosController@store');
      Route::get('/metodo/selectMetodoPago','MetodoPagoController@selectMetodoPago');
      Route::get('/proyecto/selectProyecto','ProyectoController@selectProyecto');
      Route::get('/proyecto/proyectoprogramador','ProyectoController@proyectosProgramador');
      Route::get('/problema','ProblemaController@index');
      Route::post('/problema/registrar','ProblemaController@store');
      Route::get('/usuario/selectProyecto','ProyectoController@selectProyecto');
      Route::put('/problema/actualizarProblema','ProblemaController@actualizarProblema');
    });
    //Rutas para el usuario 'Cliente'
    Route::group(['middleware' => ['Cliente']], function () {
      Route::get('/proyecto/proyectocliente','ProyectoController@proyectosCliente');
      Route::put('/proyecto/cancelar','ProyectoController@cancelar');
      Route::get('/problema','ProblemaController@index');
      Route::post('/problema/registrar','ProblemaController@store');
      Route::get('/usuario/selectProyecto','ProyectoController@selectProyecto');
      
      //inbox cliente
      Route::get('/cliente/receptor','inboxController@inboxClienteR');
   
    
      Route::post('/inbox/enviar','inboxController@inboxNew');
      
      Route::get('/inbox/proyectoc','inboxController@ProyectoC');
      Route::get('/inbox/manager','inboxController@Manager');
    });
});

