<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sitio;
use Illuminate\Support\Facades\Auth;


class SitioController extends Controller
{
    //Función para mostrar todos los registros de la tabla 'rol' dependiendo de lo que se busque o no
    public function index(Request $request)
    {
        $sitio = Sitio::join('usuarios','sitios.id_usuario','=','usuarios.id')
        ->select('usuarios.nombre','sitios.actividades','sitios.acercade','sitios.ubicacion','sitios.piepagina')
        ->where('sitios.id_usuario','=',Auth::user()->id)->first();
        return view('sitiofreelancer')->with('sitio', $sitio);
    }
    public function listarInfoSitios(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //Verifica que el input del texto a buscar este vacio, en ese caso, realiza un select para recopilar los datos necesarios para llevar a cabo el crud y los ordena descendiente y los pagina de 5 en 5
        if ($buscar == '') {
            $sitios = Sitio::join('usuarios','sitios.id_usuario','=','usuarios.id')
            ->select('sitios.id','sitios.actividades','usuarios.nombre as unombre','sitios.acercade','sitios.ubicacion','sitios.piepagina')
            ->where('sitios.id_usuario','=',Auth::user()->id)
            ->orderBy('sitios.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $sitios = Sitio::join('usuarios','sitios.id_usuario','=','usuarios.id')
            ->select('sitios.id','sitios.actividades','usuarios.nombre as unombre','sitios.acercade','sitios.ubicacion','sitios.piepagina')
            ->where('sitios.'.$criterio,'like','%'.$buscar.'%', 'AND', 'sitios.id_usuario','=',Auth::user()->id)
            ->orderBy('sitios.id','desc')
            ->paginate(5);
        }
        //Declaracion del arreglo 'pagination' que tiene los elementos necesarios para las funciones, siguiente, ir a la pagina y anterior
        return [
            'pagination' => [
                'total' => $sitios->total(),
                'current_page' => $sitios->currentPage(),
                'per_page' => $sitios->perPage(),
                'last_page' => $sitios->lastPage(),
                'from' => $sitios->firstItem(),
                'to' => $sitios->lastItem(),
            ],
            'sitios' => $sitios
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $sitio = new Sitio();
        $sitio->id_usuario = Auth::user()->id;
        $sitio->actividades = $request->actividades;
        $sitio->acercade = $request->acercade;
        $sitio->ubicacion = $request->ubicacion;
        $sitio->piepagina = $request->piepagina;
        $sitio->save();
    }
}
