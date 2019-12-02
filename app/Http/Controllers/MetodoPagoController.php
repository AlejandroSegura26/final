<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MetodoPago;
use App\metodocantpago;
class MetodoPagoController extends Controller
{

    public function index(Request $request){
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
        $metodo = MetodoPago::orderBy('id', 'desc')->paginate(10);
         }
         else{
        $metodo = MetodoPago::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
          }

       return [
        'pagination' => [
            'total' => $metodo->total(),
            'current_page' => $metodo->currentPage(),
            'per_page' => $metodo->perPage(),
            'last_page' => $metodo->lastPage(),
            'from' => $metodo->firstItem(),
            'to' => $metodo->lastItem(),
        ],
        'metodo' => $metodo
    ];

    }
    public function store(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'proveedores' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Declaración del objeto 'usuarios'
        $metodo = new MetodoPago();
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
        $metodCPago= new metodocantpago();
        $metodCPago->cantidad_actual=0;
         $metodCPago->id_metodo_pago=$metodo->id;
        $metodCPago->save();
    }

    public function update(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'proveedores' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Declaración del objeto 'usuarios'

        $metodo = MetodoPago::findOrFail($request->id);
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
      
    }

    //Función para desactivar un usuario
    public function desactivar(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Declaración del objeto artículo que busca un determinado registro para actualizarlo, en caso, de que no exista, nos mostrara un error en consola
        $metodo = MetodoPago::findOrFail($request->id);
        //Asigna el valor para desactivar la condición y actualiza el registro
        $metodo->estado_mp = 0;
        $metodo->save();
    }


    //Función para desactivar un usuario
    public function activar(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Declaración del objeto artículo que busca un determinado registro para actualizarlo, en caso, de que no exista, nos mostrara un error en consola
        $metodo = MetodoPago::findOrFail($request->id);
        //Asigna el valor para desactivar la condición y actualiza el registro
        $metodo->estado_mp = 1;
        $metodo->save();
    }


    public function selectMetodoPago(Request $request){
        $metodo = MetodoPago::where('estado_mp','=','1')
        ->select('id','nombre_mp')->orderBy('nombre_mp','asc')->get();
        return ['metodo' => $metodo];
    }
}
