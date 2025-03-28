<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\QuejaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsuariosController;
use App\Models\Respuesta;

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
    return view('auth.login');
});

// login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Menu principal
Route::get('/menuPrincipal', [App\Http\Controllers\DependenciaController::class, 'verMenu'])->name('menuPrincipal');

//usuarios
Route::post('/AltaUsuarios', [UsuariosController::class, 'crearUsuario'])->name('usuarios.store')->middleware('auth');
Route::get('usuarios/create', [UsuariosController::class, 'createUser'])->name('usuarios.create')->middleware('auth');
Route::get('/Verusuarios', [UsuariosController::class, 'indexUsuarios'])->name('usuarios.index')->middleware('auth');
Route::put('/actualizar-password/{id}', [UsuariosController::class, 'actualizarPassword'])->name('actualizar.password');
Route::put('/usuarios/{id}/desactivar', [UsuariosController::class, 'desactivar'])->name('usuarios.desactivar');
Route::post('/usuarios/reactivar/{id}', [UsuariosController::class, 'reactivar'])->name('usuarios.reactivar');

// Rutas para Dependencias
Route::get('/dependencias/create', [DependenciaController::class, 'mostrarFormularioCrear'])->name('dependencias.create')->middleware('auth');
Route::post('/Altadependencias', [DependenciaController::class, 'crearDependencia'])->name('dependencias.store')->middleware('auth');
Route::get('/Verdependencias', [DependenciaController::class, 'indexDependencia'])->name('dependencias.index')->middleware('auth');
Route::get('/dependencias/search', [DependenciaController::class, 'searchDependencias'])->name('dependencias.search');

// Rutas para Áreas
Route::get('/areas/create', [AreaController::class, 'mostrarFormularioCrearArea'])->name('areas.create')->middleware('auth');
Route::post('/Altaareas', [AreaController::class, 'crearArea'])->name('areas.store')->middleware('auth');
Route::get('/Verareas', [AreaController::class, 'indexArea'])->name('areas.index')->middleware('auth');
Route::get('/mostrarFor', [AreaController::class, 'mostrarFor'])->name('areas')->middleware('auth');
Route::get('/areas/por-dependencia', [AreaController::class, 'obtenerAreasPorDependencia'])->name('areas.porDependencia');

// Rutas para Quejas
Route::get('quejas/create', [QuejaController::class, 'create'])->name('quejas.create');
Route::post('quejas', [QuejaController::class, 'CrearQueja'])->name('quejas.store');
Route::get('/Verquejas', [QuejaController::class, 'VerQuejas'])->name('quejas.listaQuejas')->middleware('auth');
Route::put('/quejas/{id}/estado', [QuejaController::class, 'cambiarEstadoQueja'])->name('quejas.updateStatus');
Route::delete('/quejas/{id}/eliminar', [QuejaController::class, 'eliminarQueja'])->name('quejas.eliminarQueja');
Route::post('/quejas/responder', [RespuestaController::class, 'responder'])->name('quejas.responder');



