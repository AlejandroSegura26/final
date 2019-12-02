<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\gastos;
use App\metodocantpago;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GastosController extends Controller
{
    public function index(Request $request){
       //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $gastos =gastos::join('usuarios','usuarios.id','=','gastos.id_usuario')->join('proyecto','proyecto.id','=','gastos.id_proyecto')->join('metodo_pagos AS mp','mp.id','=','gastos.id_metodo_pago')
            ->select('gastos.codigo_retiro','gastos.id','gastos.id_usuario','usuarios.nombre','proyecto.titulo','gastos.descripcion','gastos.fecha_gasto','gastos.estado','gastos.monto','mp.nombre_mp')
            ->where('gastos.id_usuario','=',Auth::user()->id)
            ->orderBy('gastos.id','desc')
            ->paginate(5);

        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $gastos =gastos::join('usuarios','usuarios.id','=','gastos.id_usuario')->join('proyecto','proyecto.id','=','gastos.id_proyecto')->join('metodo_pagos AS mp','mp.id','=','gastos.id_metodo_pago')
            ->select('gastos.codigo_retiro','gastos.id','gastos.id_usuario','usuarios.nombre','proyecto.titulo','gastos.descripcion','gastos.fecha_gasto','gastos.estado','gastos.monto','mp.nombre_mp')
            ->where('gastos.'.$criterio,'like','%'.$buscar.'%','AND','gastos.id_usuario','=',Auth::user()->id)
            ->orderBy('gastos.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $gastos->total(),
                   'current_page' => $gastos->currentPage(),
                   'per_page' => $gastos->perPage(),
                   'last_page' => $gastos->lastPage(),
                   'from' => $gastos->firstItem(),
                   'to' => $gastos->lastItem(),
               ],
               'gastos' => $gastos
           ];
    }

  public function vistaaprobar(Request $request){
  //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;

            if ($buscar == '') {
            $gastos =gastos::join('usuarios','usuarios.id','=','gastos.id_usuario')->join('proyecto','proyecto.id','=','gastos.id_proyecto')->join('metodo_pagos AS mp','mp.id','=','gastos.id_metodo_pago')->join('metodo_cant_pago AS mcp','mcp.id_metodo_pago','=','gastos.id_metodo_pago')
            ->select('gastos.codigo_retiro','gastos.id','gastos.id_metodo_pago','gastos.id_usuario','usuarios.nombre','proyecto.titulo','gastos.descripcion','gastos.fecha_gasto','gastos.estado','gastos.monto','mp.nombre_mp','mcp.cantidad_actual')
            ->orderBy('gastos.id','desc')
            ->paginate(5);

        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $gastos =gastos::join('usuarios','usuarios.id','=','gastos.id_usuario')->join('proyecto','proyecto.id','=','gastos.id_proyecto')->join('metodo_pagos AS mp','mp.id','=','gastos.id_metodo_pago')->join('metodo_cant_pago AS mcp','mcp.id_metodo_pago','=','gastos.id_metodo_pago')
            ->select('gastos.codigo_retiro','gastos.id','gastos.id_metodo_pago','gastos.id_usuario','usuarios.nombre','proyecto.titulo','gastos.descripcion','gastos.fecha_gasto','gastos.estado','gastos.monto','mp.nombre_mp','mcp.cantidad_actual')
            ->where('gastos.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('gastos.id','desc')
            ->paginate(5);
        }

           return [
               'pagination' => [
                   'total' => $gastos->total(),
                   'current_page' => $gastos->currentPage(),
                   'per_page' => $gastos->perPage(),
                   'last_page' => $gastos->lastPage(),
                   'from' => $gastos->firstItem(),
                   'to' => $gastos->lastItem(),
               ],
               'gastos' => $gastos
           ];
  }

  public function store(Request $request){
            $gastos = new gastos();
     $mytime = Carbon::now('America/Mexico_City');
            $gastos -> codigo_retiro = $request -> codigo_retiro;
            $gastos -> descripcion = $request -> descripcion;
            $gastos -> fecha_gasto = $mytime->toDateString();
            $gastos -> estado = 0;
            $gastos -> monto = $request -> monto;
            $gastos -> id_metodo_pago = $request -> id_metodo_pago;
            $gastos -> id_proyecto = $request -> id_proyecto;
            $gastos -> id_usuario = Auth::user()->id;
    
            $gastos -> save();

    }

  public function rechazar(Request $request){


             $gastos = gastos::findOrFail($request->id);
             $gastos -> estado = 2;
             $gastos -> save();

    }

  public function aceptar(Request $request){

          
             $gastos = gastos::findOrFail($request->id);
             $gastos -> estado = 1;
             $gastos -> save();
          
    }

    public function change(Request $request){
            $cantpago = metodocantpago::findOrFail($request->id_metodo_pago);
             
             //$quitar = DB::table('metodo_cant_pago')->select('cantidad_actual')->where('id_metodo_pago','=',$gastos->id_metodo_pago);
             
             $cantpago -> cantidad_actual = $request -> actual;
             
             
             $cantpago -> save();
    }


}
