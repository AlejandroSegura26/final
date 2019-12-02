<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\inbox;
use App\User;
use App\Proyecto;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
class inboxController extends Controller
{
  
  
    public function inboxClienteR(Request $request){

 $usuario = auth::user()->id;
      
             $inbox = inbox::join('usuarios AS e','e.id','=','inbox.emisor')-> join('usuarios AS r','r.id','=','inbox.receptor')->join('proyecto AS p','p.id','=','inbox.id_proyecto')
              ->select('p.estado','inbox.emisor','inbox.receptor','e.nombre AS nombre_emisor','r.nombre AS nombre_receptor','p.id_manager','inbox.id_proyecto','p.titulo','inbox.mensaje','inbox.id','inbox.fecha_envio')
          -> where('inbox.receptor','=',$usuario)->orWhere('inbox.emisor','=',$usuario)
             ->orderBy('inbox.id','desc')
               ->paginate(5);
            return [
               'pagination' => [
                   'total' => $inbox->total(),
                   'current_page' => $inbox->currentPage(),
                   'per_page' => $inbox->perPage(),
                   'last_page' => $inbox->lastPage(),
                   'from' => $inbox->firstItem(),
                   'to' => $inbox->lastItem(),
               ],
               'inbox' => $inbox
           ];
    }

    public function inboxManagerR(Request $request){
        $usuario = auth::user()->id;
       $inbox = inbox::join('usuarios AS e','e.id','=','inbox.emisor')-> join('usuarios AS r','r.id','=','inbox.receptor')->join('proyecto AS p','p.id','=','inbox.id_proyecto')
              ->select('p.estado','inbox.emisor','inbox.receptor','e.nombre AS nombre_emisor','r.nombre AS nombre_receptor','p.id_manager','inbox.id_proyecto','p.titulo','inbox.mensaje','inbox.id','inbox.fecha_envio')
           -> where('inbox.receptor','=',$usuario)->orWhere('inbox.emisor','=',$usuario)
          ->orderBy('inbox.id','desc')    
         ->paginate(5);
            return [
               'pagination' => [
                   'total' => $inbox->total(),
                   'current_page' => $inbox->currentPage(),
                   'per_page' => $inbox->perPage(),
                   'last_page' => $inbox->lastPage(),
                   'from' => $inbox->firstItem(),
                   'to' => $inbox->lastItem(),
               ],
               'inbox' => $inbox
           ];
    }
  
    public function inboxGeneral(Request $request){
       $inbox = inbox::join('usuarios AS e','e.id','=','inbox.emisor')-> join('usuarios AS r','r.id','=','inbox.receptor')->join('proyecto AS p','p.id','=','inbox.id_proyecto')
              ->select('p.id_cliente','inbox.emisor','inbox.receptor','e.nombre AS nombre_emisor','r.nombre AS nombre_receptor','p.id_manager','inbox.id_proyecto','p.titulo','inbox.mensaje','inbox.id','inbox.fecha_envio')
             
          ->orderBy('inbox.id','desc')     
         ->paginate(5);
            return [
               'pagination' => [
                   'total' => $inbox->total(),
                   'current_page' => $inbox->currentPage(),
                   'per_page' => $inbox->perPage(),
                   'last_page' => $inbox->lastPage(),
                   'from' => $inbox->firstItem(),
                   'to' => $inbox->lastItem(),
               ],
               'inbox' => $inbox
           ];
    }
  
    //registro para nuevos inboxs
    public function inboxNew(Request $request){
      $inbox = new inbox();
      $mytime = Carbon::now('America/Mexico_City');
      $inbox -> fecha_envio = $mytime->toDateString();
      $inbox -> id_proyecto = $request -> id_proyecto;
      $inbox -> emisor = Auth::user()->id;
      $inbox -> receptor = $request -> receptor;
      $inbox -> mensaje = $request -> mensaje;
      $inbox -> save();
    }
   
    //selects necesario para inbox
    public function ProyectoC(Request $request){
       
        //if (!$request->ajax()) return redirect('/');
        $proyecto = Proyecto::where('estado','=','inicializado','AND','id_cliente','=',Auth::user()->id)
        ->select('id','titulo')->orderBy('titulo','asc')->get();
        return ['proyecto' => $proyecto];
    }
    
  
    public function Manager(Request $request){
       // if (!$request->ajax()) return redirect('/');
        $manager = Proyecto::join('usuarios AS m','m.id','=','proyecto.id_manager')
        ->select('m.id','m.nombre')
          ->where('proyecto.estado','=','inicializado','AND','proyecto.id_cliente','=',Auth::user()->id)
          ->orderBy('m.nombre','asc')->get();
          return ['manager' => $manager];
    }
  public function Clientes(Request $request){
      //if (!$request->ajax()) return redirect('/');
        $clientes = Proyecto::join('usuarios AS c','c.id','=','proyecto.id_cliente')
        ->select('c.id','c.nombre')
          ->where('proyecto.estado','=','inicializado','AND','proyecto.id_manager','=',Auth::user()->id)
          ->orderBy('c.nombre','asc')->get();
        return ['cliente' => $clientes];
    }
    public function proyectoM(Request $request){
       //if (!$request->ajax()) return redirect('/');
        $proyecto = Proyecto::where('estado','=','inicializado','AND','id_manager','=',Auth::user()->id)
        ->select('id','titulo')->orderBy('titulo','asc')->get();
        return ['proyecto' => $proyecto];
    }
    
    
}
