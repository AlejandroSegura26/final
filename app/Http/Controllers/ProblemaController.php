<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Problema;
use Illuminate\Support\Facades\Auth;

class ProblemaController extends Controller
{
    //Función para mostrar todos los registros de la tabla 'usuarios' dependiendo de lo que se busque o no
    public function index(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //Verifica que el input del texto a buscar este vacio, en ese caso, realiza un select para recopilar los datos necesarios para llevar a cabo el crud y los ordena descendiente y los pagina de 5 en 5
        if ($buscar == '') {
            $problemas = Problema::join('usuarios','problemas.usuario_id','=','usuarios.id')
            ->join('proyecto','problemas.proyecto_id','=','proyecto.id')
            ->select('problemas.id','problemas.proyecto_id','usuarios.nombre as pnombre','problemas.descripcion','problemas.estado','proyecto.titulo as ptitulo', 'usuarios.rol_id')
            ->where('proyecto.id_cliente','=',Auth::user()->id)
            ->orderBy('problemas.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $problemas = Problema::join('usuarios','problemas.usuario_id','=','usuarios.id')
            ->join('proyecto','problemas.proyecto_id','=','proyecto.id')
            ->select('problemas.id','problemas.proyecto_id','usuarios.nombre as pnombre','problemas.descripcion','problemas.estado','proyecto.titulo as ptitulo', 'usuarios.rol_id')
            ->where('problemas.'.$criterio,'like','%'.$buscar.'%', 'AND', 'proyecto.id_cliente','=',Auth::user()->id)
            ->orderBy('problemas.id','desc')
            ->paginate(5);
        }
        //Declaracion del arreglo 'pagination' que tiene los elementos necesarios para las funciones, siguiente, ir a la pagina y anterior
        return [
            'pagination' => [
                'total' => $problemas->total(),
                'current_page' => $problemas->currentPage(),
                'per_page' => $problemas->perPage(),
                'last_page' => $problemas->lastPage(),
                'from' => $problemas->firstItem(),
                'to' => $problemas->lastItem(),
            ],
            'problemas' => $problemas
        ];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $problema = new Problema();
        $problema->usuario_id = Auth::user()->id;
        $problema->descripcion = $request->descripcion;
        $problema->estado = 1;
        $problema->proyecto_id = $request->proyecto_id;
        $problema->save();
    }
    public function asignarProgramador(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $problema = Problema :: findOrFail($request->id);
        $problema->usuario_id = $request->usuario_id;
        $problema->save();
    }
    public function actualizarProblema(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $problema = Problema :: findOrFail($request->id);
        $problema->estado = $request->estado;
        $problema->save();
    }
    public function problemasAdmin(Request $request){
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //Verifica que el input del texto a buscar este vacio, en ese caso, realiza un select para recopilar los datos necesarios para llevar a cabo el crud y los ordena descendiente y los pagina de 5 en 5
        if ($buscar == '') {
            $problemas = Problema::join('usuarios','problemas.usuario_id','=','usuarios.id')
            ->join('proyecto','problemas.proyecto_id','=','proyecto.id')
            ->select('problemas.id','problemas.proyecto_id','usuarios.nombre as pnombre','problemas.descripcion','problemas.estado','proyecto.titulo as ptitulo', 'usuarios.rol_id')
            ->orderBy('problemas.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $problemas = Problema::join('usuarios','problemas.usuario_id','=','usuarios.id')
            ->join('proyecto','problemas.proyecto_id','=','proyecto.id')
            ->select('problemas.id','problemas.proyecto_id','usuarios.nombre as pnombre','problemas.descripcion','problemas.estado','proyecto.titulo as ptitulo', 'usuarios.rol_id')
            ->where('problemas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('problemas.id','desc')
            ->paginate(5);
        }
        //Declaracion del arreglo 'pagination' que tiene los elementos necesarios para las funciones, siguiente, ir a la pagina y anterior
        return [
            'pagination' => [
                'total' => $problemas->total(),
                'current_page' => $problemas->currentPage(),
                'per_page' => $problemas->perPage(),
                'last_page' => $problemas->lastPage(),
                'from' => $problemas->firstItem(),
                'to' => $problemas->lastItem(),
            ],
            'problemas' => $problemas
        ];
    }
}
