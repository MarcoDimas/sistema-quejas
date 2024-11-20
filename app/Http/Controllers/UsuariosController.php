<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Roles;

class UsuariosController extends Controller
{


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
}
