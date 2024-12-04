<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class UsuariosController extends Controller
{


    public function indexUsuarios(Request $request)
{
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->id_roles;
        $userDependencia = $user->id_dependencia;

        $filtroDependencia = $request->input('dependencia_id');


        
        if ($userRole == 1) {
            $query = User::query();
        } else {
            $query = User::where('id_dependencia', $userDependencia);

        }
        if ($filtroDependencia) {
            $query->where('id_dependencia', $filtroDependencia);
        }

        $usuarios = $query->get();
        $dependencias = Dependencia::all();


        return view('usuarios.index', compact('usuarios', 'dependencias'));
    }
}


    public function createUser()
    {
        $usuarioLogueado = auth()->user();
    
        if ($usuarioLogueado->id_roles == 1) {
            // Si el usuario es un Super Administrador, mostrar todas las dependencias y roles
            $dependencias = Dependencia::all();
            $roles = Roles::all();
        } elseif ($usuarioLogueado->id_roles == 2) {
            // Si el usuario es un Administrador, mostrar solo sus dependencias y roles específicos
            $dependencias = Dependencia::where('id', $usuarioLogueado->id_dependencia)->get();
            $roles = Roles::whereIn('id', [2, 3])->get();
        } else {
            
            return redirect()->route('login')->with('error', 'No tienes permisos para crear usuarios.');
        }
    
        return view('usuarios.create', compact('dependencias', 'roles'));
    }
    


    public function crearUsuario(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:500',
            'email' =>  'required|email|regex:/^.+@.+\..+$/i',
            'password' => 'required|string|max:255',
            'id_dependencia' => 'required|exists:dependencias,id',
            'id_roles' => 'required|exists:roles,id',
        ]);

        $usuario = new User;
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        $usuario->id_roles = $request->input('id_roles');
        $usuario->id_dependencia = $request->input('id_dependencia');
        $usuario->estatus = 1;
        $usuario->save();

        return redirect()->route('usuarios.create')->with('success', 'Usuario creado exitosamente')->with('reload', true);
    }



    public function actualizarPassword(Request $request, $id)
{
    $usuario = User::findOrFail($id);
    $usuario->password = bcrypt($request->password);
    $usuario->save();

    return redirect()->route('usuarios.index')->with('success', 'Contraseña actualizada exitosamente.')->with('reload', true);
}


public function desactivar($id)
{
    $usuario = User::findOrFail($id);
    $usuario->estatus = false; // Establecer estatus a false para desactivar el usuario
    $usuario->save();

    return redirect()->back()->with('success', 'Usuario desactivado exitosamente.')->with('reload', true);
}
public function reactivar($id)
{
    $usuario = User::find($id);
    
    if ($usuario) {
        $usuario->estatus = 1; // Cambiar el estatus a activo
        $usuario->save();

        return redirect()->back()->with('success', 'Usuario reactivado con éxito.')->with('reload', true);
    }

    return redirect()->back()->with('error', 'Usuario no encontrado.');
}

}
