<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Proyecto;

class ProyectoController extends Controller
{

       public function index(Request $request)
       {

           //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;
         
            if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre as cnombre','manager.nombre as mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $proyecto->total(),
                   'current_page' => $proyecto->currentPage(),
                   'per_page' => $proyecto->perPage(),
                   'last_page' => $proyecto->lastPage(),
                   'from' => $proyecto->firstItem(),
                   'to' => $proyecto->lastItem(),
               ],
               'proyecto' => $proyecto
           ];
       }

       public function store(Request $request)
       {
           if (!$request->ajax()) return redirect('/');
         
         $proyecto = new Proyecto();
         $proyecto -> titulo = $request -> titulo;
         $proyecto -> id_cliente = $request -> id_cliente;
         $proyecto -> id_manager = $request -> id_manager;
         $proyecto -> fecha_inicio = $request -> fecha_inicio;
         $proyecto -> fecha_final = $request -> fecha_final;
         $proyecto -> descripcion = $request -> descripcion;
         $proyecto -> estado = 'inicializado';
         $proyecto -> save();
       }

       public function update(Request $request)
       {
           if (!$request->ajax()) return redirect('/');
          $proyecto = Proyecto :: findOrFail($request->id);
         $proyecto -> titulo = $request -> titulo;
         $proyecto -> id_cliente = $request -> id_cliente;
         $proyecto -> id_manager = $request -> id_manager;
         $proyecto -> fecha_inicio = $request -> fecha_inicio;
         $proyecto -> fecha_final = $request -> fecha_final;
         $proyecto -> descripcion = $request -> descripcion;
         $proyecto -> estado = 'inicializado';
         $proyecto -> save();
       }

       public function desactivar(Request $request)
       {
          if (!$request->ajax()) return redirect('/');
         $proyecto = Proyecto :: findOrFail($request->id);
         $proyecto -> estado = 'finalizado';
         $proyecto -> save();
       }
  
  //funcion que trae los proyectos en los que se encuentra los managers
        public function proyectosManager(Request $request){
          if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.id_manager','=',Auth::user()->id)
              ->orderBy('proyecto.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','mnombre.nombre AS manager','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%','AND','proyecto.id_manager','=',Auth::user()->id)
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $proyecto->total(),
                   'current_page' => $proyecto->currentPage(),
                   'per_page' => $proyecto->perPage(),
                   'last_page' => $proyecto->lastPage(),
                   'from' => $proyecto->firstItem(),
                   'to' => $proyecto->lastItem(),
               ],
               'proyecto' => $proyecto
           ];
       
        }
  //funcion que trae los proectos en los que se encuentra el programador
  public function proyectosProgramador(Request $request){
        
            if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
              ->join('miembros_proyecto','miembro_proyecto.id_proyecto','=','proyecto.id')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('miembros_proyecto.id_usuario','=',Auth::user()->id)
              ->orderBy('proyecto.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%','AND','miembros_proyecto.id_usuario','=',Auth::user()->id)
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $proyecto->total(),
                   'current_page' => $proyecto->currentPage(),
                   'per_page' => $proyecto->perPage(),
                   'last_page' => $proyecto->lastPage(),
                   'from' => $proyecto->firstItem(),
                   'to' => $proyecto->lastItem(),
               ],
               'proyecto' => $proyecto
           ];
       
        }
  //funcion que trae los proectos en los que se encuentra el cliente
    public function proyectosCliente(Request $request){
          if (!$request->ajax()) return redirect('/');
            if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
              ->where('proyecto.id_cliente','='.Auth::user()->id)
              ->orderBy('proyecto.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cliente','manager.nombre AS manager','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%','AND','proyecto.id_cliente','='.Auth::user()->id)
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $proyecto->total(),
                   'current_page' => $proyecto->currentPage(),
                   'per_page' => $proyecto->perPage(),
                   'last_page' => $proyecto->lastPage(),
                   'from' => $proyecto->firstItem(),
                   'to' => $proyecto->lastItem(),
               ],
               'proyecto' => $proyecto
           ];
       
        }
}
