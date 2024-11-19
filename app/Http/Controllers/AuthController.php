<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function verMenu()
    {
        return view('menuPrincipal');
    }

    public function login(Request $request)
{
    // Validar las credenciales del usuario
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $user = User::where('email', $request->email)->first();


    // Verificar si el usuario existe
    if ($user) {

        if ($user->estatus == "0") { // Comparación no estricta

            return redirect()->back()->with('error', 'Tu cuenta está desactivada. Contacta al administrador.')->withInput($request->only('email'));
        }

        if (Auth::attempt($request->only('email', 'password'))) {

            return redirect()->route('menuPrincipal');
        } else {

            return redirect()->back()->with('error', 'Credenciales inválidas')->withInput();
        }
    }


    return redirect()->back()->with('error', 'Credenciales inválidas')->withInput();
}


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
