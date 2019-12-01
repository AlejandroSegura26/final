<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
use App\Hito;
class TareaController extends Controller
{
  
  public function index(Request $request)
       {

           //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;
         
            if ($buscar == '') {
            $tarea =Tarea::join('hitos','hitos.id','=','tareas.hito_id')
              ->join('usuarios','usuarios.id','=','tareas.miembro_id')
            ->select('tareas.id','tareas.descripcion','hitos.titulo','usuarios.nombre','tareas.fecha_inicio','tareas.horas','tareas.estado')
            ->orderBy('tareas.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        }  else {
           $tarea =Tarea::join('hitos','hitos.id','=','tareas.hito_id')
              ->join('usuarios','usuarios.id','=','tareas.miembro_id')
            ->select('tareas.id','tareas.descripcion','hitos.titulo','usuarios.nombre','tareas.fecha_inicio','tareas.horas','tareas.estado')
            ->where('tareas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('tareas.id','desc')
            ->paginate(5);
       } 
    
      return [
            'pagination' => [
                'total' => $tarea->total(),
                'current_page' => $tarea->currentPage(),
                'per_page' => $tarea->perPage(),
                'last_page' => $tarea->lastPage(),
                'from' => $tarea->firstItem(),
                'to' => $tarea->lastItem(),
            ],
            'tareas' => $tarea
        ];
  }
  
    public function store(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'proveedores' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Declaración del objeto 'usuarios'
        
         $hito =Hito:: select('hitos.id')
            ->where('hitos.id','=',$request->hito_id)
              ->where('hitos.estado','=',1)
              ->count();
        if($hito>0)
        {
          $tarea = new Tarea();
          $tarea->hito_id = $request->hito_id;
          $tarea->miembro_id = $request->miembro_id;
          $tarea->fecha_inicio = $request->fecha_inicio;
          $tarea->horas = $request->horas;
          $tarea->descripcion = $request->descripcion;
          $tarea->estado = 1;
          $tarea->save();
          return 1;
        }
        else
          return 0;
    }
  
      public function desactivar(Request $request)
       {
          if (!$request->ajax()) return redirect('/');
              $tarea = Tarea :: findOrFail($request->id);
               $tarea -> estado = 0;
               $tarea -> save();
      
       }
  
/*
    public function update(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'proveedores' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Declaración del objeto 'usuarios'
      
        $metodo = Tarea::findOrFail($request->id);
        //Asignación de los valores recopilados de los inputs al objeto 'persona' que sirve para llamar al modelo y guardar el registro en la base de datos
        //$metodo->imagen_mp = $request->nombre;
        $metodo->nombre_mp = $request->nombre_mp;
        $metodo->cantidad_minretiro = $request->cantidad_minretiro;
        $metodo->cantidad_maxretiro = $request->cantidad_maxretiro;
        $metodo->cargo_retiro = $request->cargo_retiro;
        $metodo->porcentaje_cargo = $request->porcentaje_cargo;
        $metodo->taza_mp = $request->taza_mp;
        $metodo->moneda_mp = $request->moneda_mp;
        $metodo->dias_habiles = $request->dias_habiles;
        $metodo->estado_mp = 1;
        $metodo->save();
    }*/
}
