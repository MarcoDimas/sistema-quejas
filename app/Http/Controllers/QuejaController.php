<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dependencia;
use App\Models\Area;
use App\Models\Queja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuejaRechazadaMail;
use Illuminate\Support\Facades\Log;
use App\Mail\QuejaEnProcesoMail;
use App\Mail\QuejaResueltaMail;

class QuejaController extends Controller


{

    public function VerQuejas(Request $request)
{
    if (Auth::check()) {
        $user = Auth::user();
        $userRole = $user->id_roles;
        $userDependencia = $user->id_dependencia;

        // Obtener los parámetros del filtro
        $filtroDependencia = $request->input('dependencia_id');
        $filtroArea = $request->input('area_id');
        $filtroEstado = $request->input('estado');

        // Construir la consulta base
        $query = Queja::with(['dependencia', 'area']);

        // Lógica de visibilidad según el rol
        if ($userRole == 1) {
            // Rol 1: Puede ver todas las quejas
            $dependencias = Dependencia::with('areas')->get(); 
        } elseif ($userRole == 3) {
            // Rol 3: Solo puede ver sus propias quejas
            $query->where('usuario_id', $user->id);
            $dependencias = Dependencia::with('areas')->where('id', $userDependencia)->get();
        } else {
            // Otros roles: Solo ven quejas de su dependencia
            $query->where('dependencia_id', $userDependencia);
            $dependencias = Dependencia::with('areas')->where('id', $userDependencia)->get();
        }

        // Aplicar filtros de búsqueda
        if ($filtroDependencia) {
            $query->where('dependencia_id', $filtroDependencia);
        }

        if ($filtroArea) {
            $query->where('area_id', $filtroArea);
        }

        if ($filtroEstado) {
            $query->where('estado', $filtroEstado);
        }

        // Obtener las quejas filtradas
        $quejas = $query->get();

        // Opciones de estados
        $estados = ['pendiente', 'en proceso', 'resuelta', 'rechazada'];

        return view('quejas.listaQuejas', compact('quejas', 'dependencias', 'estados'));
    }

    return redirect()->route('login')->with('error', 'Por favor, inicia sesión.');
}

    


    public function create()
    {
        $dependencias = Dependencia::all(); 
        return view('quejas.create', compact('dependencias'));
    }

    public function CrearQueja(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'nombre' => 'required|string|max:500',
            'email' => 'required|email|regex:/^.+@.+\..+$/i',
            'motivo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'dependencia_id' => 'required|exists:dependencias,id',
            'area_id' => 'required|exists:areas,id',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5048', // Archivos permitidos
        ]);
    
        try {
            $archivoPath = null;
    
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $archivoPath = $archivo->store('quejas_archivos', 'public');
            }
    
            $queja = new Queja();
            $queja->nombre = $request->input('nombre');
            $queja->email = $request->input('email');
            $queja->motivo = $request->input('motivo');
            $queja->descripcion = $request->input('descripcion');
            $queja->dependencia_id = $request->input('dependencia_id');
            $queja->area_id = $request->input('area_id');
            $queja->usuario_id = auth()->id() ?? 3; 

            if ($archivoPath) {
                $queja->archivo = $archivoPath; 
            }
            
            $queja->save();
    
            return redirect()->route('quejas.create')
                ->with('success', 'Queja enviada exitosamente.')
                ->with('reload', true);
    
        } catch (\Exception $e) {
            Log::error('Error al guardar la queja: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['error' => 'Ocurrió un problema al enviar la queja. Por favor, intenta nuevamente.'])
                ->withInput();
        }
    }
    


    public function cambiarEstadoQueja(Request $request, $id)
    {
        // Validar que el estado esté en un valor válido
        $request->validate(['estado' => 'required|in:pendiente,en proceso,resuelta,rechazada']);
    
        // Buscar la queja por su ID
        $queja = Queja::with(['dependencia', 'area'])->find($id);
    
        if (!$queja) {
            return redirect()->back()->with('error', 'Queja no encontrada.');
        }
     if ($request->estado === 'en proceso') {
            // Enviar correo al usuario
            if (!empty($queja->email)) {
                Mail::to($queja->email)->send(new QuejaEnProcesoMail($queja));
            }
        }      
       
        if ($request->estado === 'resuelta') {
            // Enviar correo al usuario
            if (!empty($queja->email)) {
                Mail::to($queja->email)->send(new QuejaResueltaMail($queja));
            }
        } 
        
        if ($request->estado === 'rechazada') {
            // Enviar correo al usuario
            if (!empty($queja->email)) {
                Mail::to($queja->email)->send(new QuejaRechazadaMail($queja));
            }
        }
    
        // Actualizar el estado de la queja
        $queja->estado = $request->estado;
        $queja->save();
    
        return redirect()->route('quejas.listaQuejas')->with('success', 'Estado de la queja actualizado.')->with('reload', true);
    }
    
public function eliminarQueja($id)
{
    $queja = Queja::find($id);

    if ($queja) {
        $queja->delete();
        return redirect()->route('quejas.listaQuejas')->with('success', 'Registro eliminado correctamente')->with('reload', true);
    }
}

}
