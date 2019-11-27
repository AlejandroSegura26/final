<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Se hace el llamado al modelo 'user'
use App\User;

class UserController extends Controller
{
    //Función para mostrar todos los registros de la tabla 'usuarios' dependiendo de lo que se busque o no
    public function index(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        //if (!$request->ajax()) return redirect('/');
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        //Verifica que el input del texto a buscar este vacio, en ese caso, realiza un select para recopilar los datos necesarios para llevar a cabo el crud y los ordena descendiente y los pagina de 5 en 5
        if ($buscar == '') {
            $usuarios = User::join('roles','usuarios.rol_id','=','roles.id')
            ->select('usuarios.id','usuarios.nombre','usuarios.correo_electronico','usuarios.usuario','usuarios.password','usuarios.condicion','usuarios.rol_id','roles.nombre as rol')
            ->orderBy('usuarios.id','desc')
            ->paginate(5);
        //En caso contrario devuelve aquellos registros que coinciden con el texto a buscar y lo ordena descendentemente y los pagina de 5 en 5
        } else {
            $usuarios = User::join('roles','usuarios.rol_id','=','roles.id')
            ->select('usuarios.id','usuarios.nombre','usuarios.correo_electronico','usuarios.usuario','usuarios.password','usuarios.condicion','usuarios.rol_id','roles.nombre as rol')
            ->where('usuarios.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('usuarios.id','desc')
            ->paginate(5);
        }
        //Declaracion del arreglo 'pagination' que tiene los elementos necesarios para las funciones, siguiente, ir a la pagina y anterior
        return [
            'pagination' => [
                'total' => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page' => $usuarios->perPage(),
                'last_page' => $usuarios->lastPage(),
                'from' => $usuarios->firstItem(),
                'to' => $usuarios->lastItem(),
            ],
            'usuarios' => $usuarios
        ];
    }
    //Función para almacenar un usuarios
    public function store(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'proveedores' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Declaración del objeto 'usuarios'
        $usuario = new User();
        //Asignación de los valores recopilados de los inputs al objeto 'persona' que sirve para llamar al modelo y guardar el registro en la base de datos
        $usuario->nombre = $request->nombre;
        $usuario->correo_electronico = $request->correo_electronico;
        $usuario->usuario = $request->usuario;
        $usuario->password = bcrypt($request->password);
        $usuario->condicion = '1';
        $usuario->rol_id = $request->rol_id;
        $usuario->save();
    }
    //Función para actualizar un usuario
    public function update(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Se utiliza el metodo 'beginTransaction' para hacer la insercion en la tabla 'personas' y 'users' a la vez, en caso de que no ocurra algun error, se ejecuta la transaccion, en caso contrario, se hace un rollback para eliminar la transaccion creada y no agregar el registro a la base de datos
        //Buscar el usuario a modificar
        $usuario = User::findOrFail($request->id);
        //Asignación de los valores recopilados de los inputs al objeto 'persona' que sirve para llamar al modelo y guardar el registro en la base de datos
        $usuario->nombre = $request->nombre;
        $usuario->correo_electronico = $request->correo_electronico;
        $usuario->usuario = $request->usuario;
        $usuario->password = bcrypt($request->password);
        $usuario->condicion = '1';
        $usuario->rol_id = $request->rol_id;
        $usuario->save();
    }
    //Función para desactivar un usuario
    public function desactivar(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Declaración del objeto artículo que busca un determinado registro para actualizarlo, en caso, de que no exista, nos mostrara un error en consola
        $usuario = User::findOrFail($request->id);
        //Asigna el valor para desactivar la condición y actualiza el registro
        $usuario->condicion = '0';
        $usuario->save();
    }
    //Función para activar un usuario
    public function activar(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        if (!$request->ajax()) return redirect('/');
        //Declaración del objeto artículo que busca un determinado registro para actualizarlo, en caso, de que no exista, nos mostrara un error en consola
        $usuario = User::findOrFail($request->id);
        //Asigna el valor para desactivar la condición y actualiza el registro
        $usuario->condicion = '1';
        $usuario->save();
    }
    //Devuelve todas los roles activados para utilizarse en un select
    public function selectCliente(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        //if (!$request->ajax()) return redirect('/');
        //Verifica que traiga solo los roles que estan activas y las ordena ascendentemente para guardalas en el arreglo 'roles'
        $clientes = User::where('rol_id','=','4')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['cliente' => $clientes];
    }
  
  //Devuelve todas los roles activados para utilizarse en un select
    public function selectManager(Request $request)
    {
        //Verifica que solo existan peticiones por Ajax, en caso de acceder a una ruta dirigira a la raiz
        //if (!$request->ajax()) return redirect('/');
        //Verifica que traiga solo los roles que estan activas y las ordena ascendentemente para guardalas en el arreglo 'roles'
        $manager = User::where('rol_id','=','2')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['manager' => $manager];
    }
  
}
