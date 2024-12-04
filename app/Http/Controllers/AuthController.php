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
        if (Auth::check()) {
            return redirect()->route('menuPrincipal'); // Ya está autenticado
        }
    
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $user = User::where('email', $request->email)->first();
    
        if ($user && $user->estatus == "0") {
            return redirect()->back()->with('error', 'Tu cuenta está desactivada. Contacta al administrador.');
        }
    
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->route('menuPrincipal');
        }
    
        return redirect()->back()->with('error', 'Credenciales inválidas.');
    }
    


    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
