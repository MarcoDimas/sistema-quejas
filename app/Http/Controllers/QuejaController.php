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
class QuejaController extends Controller
{

    public function VerQuejas()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $userRole = $user->id_roles;
            $userDependencia = $user->id_dependencia;
    
            if ($userRole == 1) {
                // Si el usuario tiene rol 1, mostrar todos los registros con sus relaciones
                $quejas = Queja::with(['dependencia', 'area'])->get();
            } elseif ($userRole == 3) {
                // Si el usuario tiene rol 3, mostrar solo las quejas que él creó
                $quejas = Queja::with(['dependencia', 'area'])
                    ->where('usuario_id', $user->id)
                    ->get();
            } else {
                // Para otros roles, mostrar las quejas de su dependencia
                $quejas = Queja::with(['dependencia', 'area'])
                    ->where('dependencia_id', $userDependencia)
                    ->get();
            }
    
            return view('quejas.listaQuejas', compact('quejas'));
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
    
        // Verificar si el estado cambia a rechazado
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
