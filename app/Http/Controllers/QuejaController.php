<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dependencia;
use App\Models\Area;
use App\Models\Queja;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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



    public function updateStatus(Request $request, $id)
    {
        // Validar que el estado esté en un valor válido
        $request->validate(['estado' => 'required|in:pendiente,en proceso,resuelta,rechazada']);
    
        // Buscar la queja por su ID
        $queja = Queja::find($id);
    
        if (!$queja) {
            return redirect()->back()->with('error', 'Queja no encontrada.');
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

public function responder(Request $request)
{
    $request->validate([
        'respondido_por' => 'required|string',
        'correo_encargado' => 'required|email',
        'descripcion' => 'required|string',
        'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
    ]);

    // Obtener los datos del formulario
    $datos = $request->only('respondido_por', 'correo_encargado', 'descripcion', 'email');
    $archivo = $request->file('archivo');

    // Enviar correo
    Mail::send('emails.respuestaQueja', $datos, function ($message) use ($datos, $archivo) {
        $message->to($datos['email'])
                ->subject('Respuesta a tu queja');
        if ($archivo) {
            $message->attach($archivo->getRealPath(), [
                'as' => $archivo->getClientOriginalName(),
                'mime' => $archivo->getClientMimeType(),
            ]);
        }
    });

    return redirect()->route('quejas.listaQuejas')->with('success', 'Respuesta enviada con éxito al correo electronico.')->with('reload', true);
}

}
