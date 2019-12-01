<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tarea;
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
            ->select('tareas.descripcion','hitos.titulo','usuarios.nombre','tareas.fecha_inicio','tareas.horas')
            ->orderBy('tareas.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } /*else {
            $proyecto =Proyecto::join('usuarios AS cliente','cliente.id','=','proyecto.id_cliente')->join('usuarios AS manager','manager.id','=','proyecto.id_manager')
            ->select('proyecto.id','cliente.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','proyecto.fecha_inicio','proyecto.fecha_final','proyecto.estado','proyecto.descripcion')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
       }*/
    
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
        $tarea = new Tarea();
        //Storage::disk('local')->put($request->imagen);
        //Asignación de los valores recopilados de los inputs al objeto 'persona' que sirve para llamar al modelo y guardar el registro en la base de datos
        //$metodo->imagen_mp = $request->nombre;
        $tarea->hito_id = $request->hito_id;
        $tarea->miembro_id = $request->miembro_id;
        $tarea->fecha_inicio = $request->fecha_inicio;
        $tarea->horas = $request->horas;
        $tarea->descripcion = $request->descripcion;
        $tarea->estado = 1;
        $tarea->save();
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
