<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dependencia;
use App\Models\Area;
use App\Models\Queja;
use Illuminate\Support\Facades\Auth;
class QuejaController extends Controller
{

    public function indexQuejas()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->id_roles;
            $userDependencia = $user->id_dependencia;
            // Si el usuario tiene rol 1, mostrar todos los registros
            if ($userRole == 1) {

        $quejas = Queja::with(['dependencia', 'area'])->get();
            } else  {
                $quejas = Queja::with(['dependencia', 'area'])->get()->where('dependencia.id', $userDependencia);

            }

        return view('quejas.listaQuejas', compact('quejas'));
    }
    }


    public function create()
    {
        $dependencias = Dependencia::all(); 
        return view('quejas.create', compact('dependencias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:500',
            'email' =>  'required|email|regex:/^.+@.+\..+$/i',
            'motivo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dependencia_id' => 'required|exists:dependencias,id',
            'area_id' => 'required|exists:areas,id',
        ]);
       

        $queja = new Queja;
        $queja->nombre = $request->input('nombre');
        $queja->email = $request->input('email');
        $queja->motivo = $request->input('motivo');
        $queja->descripcion = $request->input('descripcion');
        $queja->dependencia_id = $request->input('dependencia_id');
        $queja->area_id = $request->input('area_id');
        $queja->usuario_id = auth()->id() ?? 3; 
        $queja->save();

        return redirect()->route('quejas.create')->with('success', 'Queja enviada exitosamente')->with('reload', true);
    }
}
