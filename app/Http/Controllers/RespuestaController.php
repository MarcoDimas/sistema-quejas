<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Respuesta;
class RespuestaController extends Controller
{
    

    public function responder(Request $request)
{
    $request->validate([
        'respondido_por' => 'required|string',
        'correo_encargado' => 'required|email',
        'descripcion' => 'required|string',
        'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:5048',
    ]);

    $archivoPath = null;
    $archivo = null;


    // Guardar el archivo si se proporciona
    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $archivoPath = $archivo->store('respuestas_archivos', 'public'); // Guardar en el sistema de archivos
    }

    // Crear registro en la tabla `respuestas`
    Respuesta::create([
        'queja_id' => $request->queja_id,
        'user_id' => auth()->id(), // ID del usuario autenticado
        'respondido_por' => $request->respondido_por,
        'correo_encargado' => $request->correo_encargado,
        'descripcion' => $request->descripcion,
        'archivo' => $archivoPath,
    ]);

    // Obtener los datos del formulario para enviar correo
    $datos = $request->only('respondido_por', 'correo_encargado', 'descripcion', 'email');

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

    return redirect()->route('quejas.listaQuejas')->with('success', 'Respuesta enviada con éxito al correo electrónico y registrada en el sistema.')->with('reload', true);
}


}
