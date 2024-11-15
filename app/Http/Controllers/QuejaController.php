<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dependencia;
use App\Models\Area;
use App\Models\Queja;

class QuejaController extends Controller
{
    public function create()
    {
        $dependencias = Dependencia::all(); 
        return view('quejas.create', compact('dependencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dependencia_id' => 'required|exists:dependencias,id',
            'area_id' => 'required|exists:areas,id',
        ]);

        $queja = new Queja;
        $queja->titulo = $request->input('titulo');
        $queja->descripcion = $request->input('descripcion');
        $queja->dependencia_id = $request->input('dependencia_id');
        $queja->area_id = $request->input('area_id');
        $queja->usuario_id = auth()->id(); // ID del usuario autenticado
        $queja->save();

        return redirect()->route('quejas.create')->with('success', 'Queja enviada exitosamente');
    }
}
