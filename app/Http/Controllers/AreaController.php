<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Auth;
class AreaController extends Controller
{
    public function indexArea()
    {

        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->id_roles;
            $userDependencia = $user->id_dependencia;
            // Si el usuario tiene rol 1, mostrar todos los registros
            if ($userRole == 1) {
                $areas = Area::with('dependencia')->get();
                $areas = Area::all();
            // sino solo areas asociadas a la dependencia del usuario logueado
            }else{
                $areas = Area::all()->where('dependencia.id', $userDependencia);
            }
        return view('areas.index', compact('areas'));
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
