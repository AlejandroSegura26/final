<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MiembroProyecto;

class ProyectoMiembroController extends Controller
{
    public function index(Request $request)
    {

        if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar == '') {


        } else {

        }

        return [
            'pagination' => [
                'total' => $mproyecto->total(),
                'current_page' => $mproyecto->currentPage(),
                'per_page' => $mproyecto->perPage(),
                'last_page' => $mproyecto->lastPage(),
                'from' => $mproyecto->firstItem(),
                'to' => $mproyecto->lastItem(),
            ],
            'proyectos' => $mproyecto
        ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

    }
}
