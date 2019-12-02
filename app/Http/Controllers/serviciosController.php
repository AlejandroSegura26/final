<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\servicios;
use App\pservicios;
use Illuminate\Support\Facades\Auth;
class serviciosController extends Controller
{
    public function store(Request $request){
        $servicios = new servicios();
        $servicios -> costo = $request->costo;
        $servicios -> nombre = $request->nombre;
        $servicios -> estado = 'disponible';
        $servicios -> save();
    }
  
    public function add(Request $request){
        $servicios = new pservicios();
        $servicios -> id_proyecto = $request->id_proyecto;
        $servicios -> id_servicio = $request->id_servicio;
       
        $servicios -> save();
    }
  
    public function cancelar(Request $request){
        $servicios = servicios::findOrFail($request->id);
             $servicios-> estado = 'cancelado';
             $servicios -> save();
    }
  
    public function activar(Request $request){
             $servicios = servicios::findOrFail($request->id);
             $servicios-> estado = 'disponible';
             $servicios -> save();
    }
  
  
    public function index2(Request $request){
       //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $servicios=servicios::join('pservicios AS ps','ps.id_servicio','=','servicios.id')->join('proyecto AS p','p.id','=','ps.id_proyecto')->join('usuarios AS u','u.id','p.id_manager')
              
             ->select('servicios.id','servicios.nombre AS snombre','servicios.costo','servicios.estado','p.titulo','u.nombre AS mnombre')
            ->orderBy('servicios.id','desc')
            ->paginate(5);

        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
             $servicios=servicios::join('pservicios AS ps','ps.id_servicio','=','servicios.id')->join('proyecto AS p','p.id','=','ps.id_proyecto')->join('usuarios AS u','u.id','p.id_manager')
              
              ->select('servicios.id','servicios.nombre AS snombre','servicios.costo','servicios.estado','p.titulo','u.nombre AS mnombre')
          
            ->where('p.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('servicios.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $servicios->total(),
                   'current_page' => $servicios->currentPage(),
                   'per_page' => $servicios->perPage(),
                   'last_page' => $servicios->lastPage(),
                   'from' => $servicios->firstItem(),
                   'to' => $servicios->lastItem(),
               ],
               'servicios' => $servicios
           ];
    }
    public function index(Request $request){
       //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $servicios=servicios::select('id','nombre','costo','estado')
          
            ->orderBy('id','desc')
            ->paginate(5);

        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $servicios=servicios::select('id','nombre','costo','estado')
            ->where('servicios.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $servicios->total(),
                   'current_page' => $servicios->currentPage(),
                   'per_page' => $servicios->perPage(),
                   'last_page' => $servicios->lastPage(),
                   'from' => $servicios->firstItem(),
                   'to' => $servicios->lastItem(),
               ],
               'servicios' => $servicios
           ];
    }
}
