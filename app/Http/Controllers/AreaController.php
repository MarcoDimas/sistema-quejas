<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;
use App\Models\Dependencia;

class AreaController extends Controller
{
    public function indexArea()
    {
        $areas = Area::with('dependencia')->get();
        $areas = Area::all();
        return view('areas.index', compact('areas'));
    }

    public function mostrarFormularioCrearArea()
    {
        $dependencias = Dependencia::orderBy('id')->get();
        $dependencias = Dependencia::all();
        return view('areas.create', compact('dependencias')); 
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
