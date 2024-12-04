<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dependencia;
use Illuminate\Support\Facades\Log;

class DependenciaController extends Controller
{
    


    public function verMenu()
    {
        return view('menuPrincipal');
    }

    public function searchDependencias(Request $request)
{
    $search = $request->input('search');
    $dependencias = Dependencia::query()
        ->where('nombre', 'like', "%$search%")
        ->orWhere('descripcion', 'like', "%$search%")
        ->get();

    return response()->json($dependencias);
}


    public function indexDependencia(Request $request)
    {
        $search = $request->input('search');
        $query = Dependencia::query();
    
        // Filtrar por término de búsqueda
        if ($search) {
            $query->where('nombre', 'like', "%$search%")
                  ->orWhere('descripcion', 'like', "%$search%");
        }
    
        $dependencias = $query->get();
    
        return view('dependencias.index', compact('dependencias'));
    }
    

    public function mostrarFormularioCrear()
    {
        return view('dependencias.store');
    }


    public function crearDependencia(Request $request){
        $dependencia = new Dependencia;
        $dependencia->nombre = $request['nombre'];
        $dependencia->descripcion = $request['descripcion'];
        $dependencia->estatus = 1;
        $dependencia->save();

        
        return redirect()->route('dependencias.create')->with('success', 'Dependencia creada exitosamente')->with('reload', true);
    } 



}
