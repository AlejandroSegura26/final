<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MiembroProyecto;
use App\Proyecto;
use Illuminate\Support\Facades\Auth;
class ProyectoMiembroController extends Controller
{
    public function index(Request $request)
    {


        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS manager','manager.id','=','proyecto.id_manager')->join('miembros_proyecto','miembros_proyecto.id_proyecto','=','proyecto.id')->join('usuarios AS programador','programador.id','=','miembros_proyecto.id_usuario')
            ->select('proyecto.id','programador.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','miembros_proyecto.rol_proyecto','miembros_proyecto.tipo_pago','miembros_proyecto.cantidad')
            ->where('proyecto.id_manager','=',Auth::user()->id)
            ->orderBy('proyecto.id','desc')
            ->paginate(5);

        } else {
            $proyecto =Proyecto::join('usuarios AS manager','manager.id','=','proyecto.id_manager')->join('miembros_proyecto','miembros_proyecto.id_proyecto','=','proyecto.id')->join('usuarios AS programador','programador.id','=','miembros_proyecto.id_usuario')
            ->select('proyecto.id','programador.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','miembros_proyecto.rol_proyecto','miembros_proyecto.tipo_pago','miembros_proyecto.cantidad')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%','AND','proyecto.id_manager','=',Auth::user()->id)
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total' => $proyecto->total(),
                'current_page' => $proyecto->currentPage(),
                'per_page' => $proyecto->perPage(),
                'last_page' => $proyecto->lastPage(),
                'from' => $proyecto->firstItem(),
                'to' => $proyecto->lastItem(),
            ],
            'proyecto' => $proyecto
        ];
    }

    public function index2(Request $request)
    {


        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {
            $proyecto =Proyecto::join('usuarios AS manager','manager.id','=','proyecto.id_manager')->join('miembros_proyecto','miembros_proyecto.id_proyecto','=','proyecto.id')->join('usuarios AS programador','programador.id','=','miembros_proyecto.id_usuario')
            ->select('proyecto.id','programador.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','miembros_proyecto.rol_proyecto','miembros_proyecto.tipo_pago','miembros_proyecto.cantidad')
            ->orderBy('proyecto.id','desc')
            ->paginate(5);

        } else {
            $proyecto =Proyecto::join('usuarios AS manager','manager.id','=','proyecto.id_manager')->join('miembros_proyecto','miembros_proyecto.id_proyecto','=','proyecto.id')->join('usuarios AS programador','programador.id','=','miembros_proyecto.id_usuario')
            ->select('proyecto.id','programador.nombre AS cnombre','manager.nombre AS mnombre','proyecto.titulo','miembros_proyecto.rol_proyecto','miembros_proyecto.tipo_pago','miembros_proyecto.cantidad')
            ->where('proyecto.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('proyecto.id','desc')
            ->paginate(5);
        }

        return [
            'pagination' => [
                'total' => $proyecto->total(),
                'current_page' => $proyecto->currentPage(),
                'per_page' => $proyecto->perPage(),
                'last_page' => $proyecto->lastPage(),
                'from' => $proyecto->firstItem(),
                'to' => $proyecto->lastItem(),
            ],
            'proyecto' => $proyecto
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

      $miembro = new MiembroProyecto();
      $miembro -> id_proyecto = $request -> id_proyecto;
      $miembro -> id_usuario = $request -> id_usuario;
      $miembro -> tipo_pago = $request -> tipo_pago;
      $miembro -> cantidad = $request -> cantidad;
      $miembro -> rol_proyecto = $request -> rol_proyecto;
      $miembro -> save();


    }




}
