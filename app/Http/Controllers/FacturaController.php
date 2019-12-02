<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factura;
use App\metodocantpago;
use Illuminate\Support\Facades\Auth;
class FacturaController extends Controller
{
  
  public function index(Request $request)
       {

           //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;
         
            if ($buscar == '') 
            {
            $factura =Factura::join('usuarios','usuarios.id','=','facturas.manager_id')
              ->join('usuarios as c','c.id','=','facturas.cliente_id')
              ->join('usuarios as m','m.id','=','facturas.manager_id')
            ->select('facturas.id','facturas.codigo_factura','facturas.razon','c.nombre','facturas.fecha_factura','facturas.vencimiento_factura',
                    'facturas.monto','facturas.monto_pagado','facturas.estado_factura')
              ->where('m.id','=',Auth::user()->id)
            ->orderBy('facturas.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        }  else {
           $factura =Factura::join('usuarios','usuarios.id','=','facturas.manager_id')
              ->join('usuarios as c','c.id','=','facturas.cliente_id')
              ->join('usuarios as m','m.id','=','facturas.manager_id')
            ->select('facturas.id','facturas.codigo_factura','facturas.razon','c.nombre','facturas.fecha_factura','facturas.vencimiento_factura',
                    'facturas.monto','facturas.monto_pagado','facturas.estado_factura')
             ->where('facturas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('tareas.id','desc')
            ->paginate(5);
       } 
    
      return [
            'pagination' => [
                'total' => $factura->total(),
                'current_page' => $factura->currentPage(),
                'per_page' => $factura->perPage(),
                'last_page' => $factura->lastPage(),
                'from' => $factura->firstItem(),
                'to' => $factura->lastItem(),
            ],
            'factura' => $factura
        ];
  }
  
  
   public function index2(Request $request)
       {

           //if (!$request->ajax()) return redirect('/');
           $buscar = $request->buscar;
           $criterio = $request->criterio;
         
            if ($buscar == '') 
            {
            $factura =Factura::join('usuarios','usuarios.id','=','facturas.manager_id')
              ->join('usuarios as c','c.id','=','facturas.cliente_id')
              ->join('usuarios as m','m.id','=','facturas.manager_id')
            ->select('facturas.id','facturas.codigo_factura','facturas.razon','m.nombre','facturas.fecha_factura','facturas.vencimiento_factura',
                    'facturas.monto','facturas.monto_pagado','facturas.estado_factura')
              ->where('c.id','=',Auth::user()->id)
            ->orderBy('facturas.id','desc')
            ->paginate(5);
              
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        }  else {
           $factura =Factura::join('usuarios','usuarios.id','=','facturas.manager_id')
              ->join('usuarios as c','c.id','=','facturas.cliente_id')
              ->join('usuarios as m','m.id','=','facturas.manager_id')
            ->select('facturas.id','facturas.codigo_factura','facturas.razon','c.nombre','facturas.fecha_factura','facturas.vencimiento_factura',
                    'facturas.monto','facturas.monto_pagado','facturas.estado_factura')
             ->where('facturas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('tareas.id','desc')
            ->paginate(5);
       } 
    
      return [
            'pagination' => [
                'total' => $factura->total(),
                'current_page' => $factura->currentPage(),
                'per_page' => $factura->perPage(),
                'last_page' => $factura->lastPage(),
                'from' => $factura->firstItem(),
                'to' => $factura->lastItem(),
            ],
            'factura' => $factura
        ];
  }
  
 
     public function store(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $now = new \DateTime();
        $codigo=rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).'';   
        do
        {
          $codigo=rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).''.rand(0, 9).'';
          $cuenta =Factura:: select('facturas.id')
            ->where('facturas.codigo_factura','=',$codigo)
            ->count();
        }while($cuenta>0);
         
        $factura = new Factura();
        $factura->codigo_factura = $codigo;
        $factura->cliente_id = $request->id_cliente;
        $factura->manager_id = Auth::user()->id;
        $factura->razon = $request->razon;
        $factura->metodo_id = $request->id_metodo;
        $factura->fecha_factura =  $now;
        $factura->vencimiento_factura = $request->vencimiento_factura;
        $factura->estado_factura = 0;
        $factura->monto = $request->monto;
        $factura->monto_pagado = 0; 
        $factura->save();
         return $codigo;
    }
  
    public function update(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $factura = Factura::findOrFail($request->id);
        $factura->cliente_id = $request->id_cliente;
        $factura->razon = $request->razon;
        $factura->metodo_id = $request->id_metodo;
        $factura->vencimiento_factura = $request->vencimiento_factura;
        $factura->monto = $request->monto;
        $factura->save(); 
   
    }
     public function cancelar(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $factura = Factura::findOrFail($request->id);
        $factura->estado_factura = 2;
        $factura->save(); 
   
    }
  
   public function pago(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $factura = Factura::findOrFail($request->id);
         if($factura->monto_pagado+$request->monto>$factura->monto)
           return 0;
        else
        {
          $factura->monto_pagado=$factura->monto_pagado+$request->monto;
          if($factura->monto_pagado==$factura->monto)
            $factura->estado_factura=1;
          $factura->save();
          $metodCPago=   metodocantpago::findOrFail($factura->metodo_id);
          $metodCPago->cantidad_actual= $metodCPago->cantidad_actual+$request->monto;
          $metodCPago->save();
          return 1;
        }
        
   
    }
  
  
}
