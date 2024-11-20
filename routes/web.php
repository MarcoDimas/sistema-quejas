<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\QuejaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Menu principal
Route::get('/menuPrincipal', [App\Http\Controllers\DependenciaController::class, 'verMenu'])->name('menuPrincipal')->middleware('auth');

//usuarios
Route::post('/AltaUsuarios', [UsuariosController::class, 'crearUsuario'])->name('usuarios.store')->middleware('auth');
Route::get('usuarios/create', [UsuariosController::class, 'createUser'])->name('usuarios.create')->middleware('auth');

// Rutas para Dependencias
Route::get('/dependencias/create', [DependenciaController::class, 'mostrarFormularioCrear'])->name('dependencias.create')->middleware('auth');
Route::post('/Altadependencias', [DependenciaController::class, 'crearDependencia'])->name('dependencias.store')->middleware('auth');
Route::get('/Verdependencias', [DependenciaController::class, 'indexDependencia'])->name('dependencias.index')->middleware('auth');

// Rutas para Áreas
Route::get('/areas/create', [AreaController::class, 'mostrarFormularioCrearArea'])->name('areas.create')->middleware('auth');
Route::post('/Altaareas', [AreaController::class, 'crearArea'])->name('areas.store')->middleware('auth');
Route::get('/Verareas', [AreaController::class, 'indexArea'])->name('areas.index')->middleware('auth');
Route::get('/mostrarFor', [AreaController::class, 'mostrarFor'])->name('areas')->middleware('auth');

// Rutas para Quejas
Route::get('quejas/create', [QuejaController::class, 'create'])->name('quejas.create');
Route::post('quejas', [QuejaController::class, 'store'])->name('quejas.store')->middleware('auth');
Route::get('/Verquejas', [QuejaController::class, 'indexQuejas'])->name('quejas.listaQuejas')->middleware('auth');



