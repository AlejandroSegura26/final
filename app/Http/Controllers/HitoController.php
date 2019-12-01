<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hito;
use Illuminate\Support\Facades\Auth;
class HitoController extends Controller
{

        public function index(Request $request)
       {

           //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;
         
            if ($buscar == '') {
            $hito =Hito::join('proyecto AS p','p.id','=','hitos.id_proyecto')
            ->select('hitos.id','p.titulo as ptitulo','hitos.titulo','hitos.fecha_inicio','hitos.fecha_fin','hitos.descripcion','hitos.estado')
            ->where('p.id_manager','=',Auth::user()->id)
              ->orderBy('hitos.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
             $hito =Hito::join('proyecto AS p','p.id','=','hitos.id')
            ->select('hitos.id','p.titulo as ptitulo','hitos.titulo','hitos.fecha_inicio','hitos.fecha_fin','hitos.descripcion','hitos.estado')
               ->where('hitos.'.$criterio,'like','%'.$buscar.'%')
             ->orderBy('hitos.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $hito->total(),
                   'current_page' => $hito->currentPage(),
                   'per_page' => $hito->perPage(),
                   'last_page' => $hito->lastPage(),
                   'from' => $hito->firstItem(),
                   'to' => $hito->lastItem(),
               ],
               'hito' => $hito
           ];
       }

        public function store(Request $request)
       {
           if (!$request->ajax()) return redirect('/');
         
         $hito = new Hito();
         $hito -> id_proyecto = $request -> id_proyecto;
         $hito -> titulo = $request -> titulo;
         $hito -> fecha_inicio = $request -> fecha_inicio;
         $hito -> fecha_fin = $request -> fecha_final;
         $hito -> descripcion = $request -> descripcion;
         $hito -> save();
       }

       public function update(Request $request)
       {
            if (!$request->ajax()) return redirect('/');
          
            $hito = Hito :: findOrFail($request->id);
            $hito -> id_proyecto = $request -> id_proyecto;
            $hito -> titulo = $request -> titulo;
            $hito -> fecha_inicio = $request -> fecha_inicio;
            $hito -> fecha_fin = $request -> fecha_final;
            $hito -> descripcion = $request -> descripcion;
            $hito -> save();
       }
  
     public function selectHito(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
         if (!$request->ajax()) return redirect('/');
        //Verifica que traiga solo los roles que estan activas y las ordena ascendentemente para guardalas en el arreglo 'roles'
        $hito =Hito::join('proyecto AS p','p.id','=','hitos.id_proyecto')->join('usuarios AS u','u.id','=','p.id_manager')
            ->select('hitos.id','hitos.titulo')
            ->where('p.id_manager','=',Auth::user()->id)
            ->orderBy('hitos.id','desc')->get();
        return ['hito' => $hito];
    }
  
     public function desactivar(Request $request)
       {
         // if (!$request->ajax()) return redirect('/');
            $hito =Hito::join('tareas','tareas.hito_id','=','hitos.id')
            ->select('tareas.id')
            ->where('hitos.id','=',$request->id)
              ->where('tareas.estado','=',1)
              ->count();

             if($hito>0)
               return 0;
            else
            {
              $hito = Hito :: findOrFail($request->id);
              $hito -> estado = 0;
              $hito -> save();
              return 1;
            }
       }
  
  
}
