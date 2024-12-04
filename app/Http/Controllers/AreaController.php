<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Auth;
class AreaController extends Controller
{

    public function obtenerAreasPorDependencia(Request $request)
{
    $dependenciaId = $request->input('dependencia_id');
    $areas = Area::where('id_dependencia', $dependenciaId)->get();
    return response()->json($areas);
}

public function indexArea(Request $request)
{
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->id_roles;
        $userDependencia = $user->id_dependencia;

        $filtroDependencia = $request->input('dependencia_id', $userRole == 1 ? null : $userDependencia);
        $filtroArea = $request->input('area_id');

        if ($userRole == 1) {
            $query = Area::query(); // Admin ve todas las áreas
        } else {
            $query = Area::where('id_dependencia', $userDependencia); // Usuarios limitados a su dependencia
        }

        if ($filtroDependencia) {
            $query->where('id_dependencia', $filtroDependencia);
        }

        if ($filtroArea) {
            $query->where('id', $filtroArea);
        }

        $areas = $query->with('dependencia')->get();

        // Dependencias accesibles según el rol
        if ($userRole == 1) {
            $dependencias = Dependencia::all(); // Rol 1 ve todas las dependencias
        } else {
            $dependencias = Dependencia::where('id', $userDependencia)->get(); // Rol 2 ve solo su dependencia
        }

        // Áreas iniciales para la dependencia seleccionada (solo si hay una dependencia seleccionada)
        $areasIniciales = Area::where('id_dependencia', $filtroDependencia)->get();

        return view('areas.index', compact('areas', 'dependencias', 'userRole', 'userDependencia', 'areasIniciales'));
    }
}

    
    public function mostrarFormularioCrearArea()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->id_roles;
            $userDependencia = $user->id_dependencia;
            // Si el usuario tiene rol 1, mostrar todos los registros
            if ($userRole == 1) {

                $dependencias = Dependencia::orderBy('id')->get();
                $dependencias = Dependencia::all();
            } else {
                $dependencias = Dependencia::orderBy('id')->get();
                $dependencias = Dependencia::all();
            }
                return view('areas.create', compact('dependencias')); 
    }
}

    public function crearArea(Request $request)
    {
        $area = new Area;
        $area->nombre = $request->input('nombre');
        $area->descripcion = $request->input('descripcion');
        $area->id_dependencia = $request->input('id_dependencia');
        $area->estatus = 1;
        $area->save();

        return redirect()->route('areas.create')->with('success', 'Area creada exitosamente')->with('reload', true);
    }

}
