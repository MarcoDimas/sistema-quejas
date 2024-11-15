<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\QuejaController;
use App\Http\Controllers\RespuestaController;


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


// Menu principal
Route::get('/menuPrincipal', [App\Http\Controllers\DependenciaController::class, 'verMenu'])->name('menuPrincipal');


// Rutas para Dependencias
Route::get('/dependencias/create', [DependenciaController::class, 'mostrarFormularioCrear'])->name('dependencias.create');
Route::post('/Altadependencias', [DependenciaController::class, 'crearDependencia'])->name('dependencias.store');
Route::get('/Verdependencias', [DependenciaController::class, 'indexDependencia'])->name('dependencias.index');

// Rutas para Áreas
Route::get('/areas/create', [AreaController::class, 'mostrarFormularioCrearArea'])->name('areas.create');
Route::post('/Altaareas', [AreaController::class, 'crearArea'])->name('areas.store');
Route::get('/Verareas', [AreaController::class, 'indexArea'])->name('areas.index');
Route::get('/mostrarFor', [AreaController::class, 'mostrarFor'])->name('areas');

// Rutas para Quejas
Route::get('quejas/create', [QuejaController::class, 'create'])->name('quejas.create');
Route::post('quejas', [QuejaController::class, 'store'])->name('quejas.store');


Route::resource('quejas', QuejaController::class);
Route::resource('respuestas', RespuestaController::class);


