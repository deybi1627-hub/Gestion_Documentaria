<?php

use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\MovimientoFinancieroController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// 1. RUTA PÚBLICA: El portal principal que todos ven
Route::get('/', [DocumentoController::class, 'index'])->name('welcome');
Route::get('/portal-documentos', [DocumentoController::class, 'portal'])->name('documentos.portal');
Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');

// 2. SEGUIMIENTO PÚBLICO: Consulta de trámites por ciudadanos
Route::get('/seguimiento', function () {
    return view('seguimiento');
})->name('seguimiento.form');

Route::post('/seguimiento', [TramiteController::class, 'seguimiento'])->name('seguimiento.buscar');

// 3. DASHBOARD: La pantalla a la que entras al loguearte
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// 4. RUTAS PROTEGIDAS: Solo usuarios logueados
Route::middleware('auth')->group(function() {

    // === MESA DE PARTES - TRÁMITES ===
    Route::get('/tramites', [TramiteController::class, 'index'])->name('tramites.index');
    Route::get('/tramites/crear', [TramiteController::class, 'create'])->name('tramites.create');
    Route::post('/tramites', [TramiteController::class, 'store'])->name('tramites.store');
    Route::get('/tramites/{tramite}', [TramiteController::class, 'show'])->name('tramites.show');

    // === GESTIÓN DOCUMENTARIA ===
    Route::get('/documentos/nuevo', [DocumentoController::class, 'create'])->name('documentos.create');
    Route::post('/documentos/guardar', [DocumentoController::class, 'store'])->name('documentos.store');
    Route::delete('/documentos/{documento}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');

    // === SISTEMA FINANCIERO ===
    Route::middleware('can:admin-tramites')->prefix('finanzas')->name('finanzas.')->group(function() {
        Route::get('/', [MovimientoFinancieroController::class, 'index'])->name('index');
        Route::get('/crear', [MovimientoFinancieroController::class, 'create'])->name('create');
        Route::post('/', [MovimientoFinancieroController::class, 'store'])->name('store');
        Route::get('/{movimiento}', [MovimientoFinancieroController::class, 'show'])->name('show');
        Route::get('/{movimiento}/editar', [MovimientoFinancieroController::class, 'edit'])->name('edit');
        Route::put('/{movimiento}', [MovimientoFinancieroController::class, 'update'])->name('update');
        Route::get('/reporte', [MovimientoFinancieroController::class, 'reporte'])->name('reporte');
    });

    // === ARCHIVO ===
    Route::middleware('can:admin-tramites')->prefix('archivos')->name('archivos.')->group(function() {
        Route::get('/', [ArchivoController::class, 'index'])->name('index');
        Route::get('/crear', [ArchivoController::class, 'create'])->name('create');
        Route::post('/', [ArchivoController::class, 'store'])->name('store');
        Route::get('/{archivo}', [ArchivoController::class, 'show'])->name('show');
        Route::get('/{archivo}/editar', [ArchivoController::class, 'edit'])->name('edit');
        Route::put('/{archivo}', [ArchivoController::class, 'update'])->name('update');
        Route::post('/buscar', [ArchivoController::class, 'buscar'])->name('buscar');
        Route::get('/por-destruir', [ArchivoController::class, 'documentosPorDestruir'])->name('por-destruir');
        Route::post('/{archivo}/destruir', [ArchivoController::class, 'destruir'])->name('destruir');
    });

    // === ADMINISTRACIÓN DE TRÁMITES (Solo Admin/Secretario) ===
    Route::middleware('can:admin-tramites')->prefix('admin')->name('admin.')->group(function() {
        Route::get('/tramites', [TramiteController::class, 'adminIndex'])->name('tramites.index');
        Route::post('/tramites/{tramite}/cambiar-estado', [TramiteController::class, 'cambiarEstado'])->name('tramites.cambiar-estado');
    });

    // === PERFIL DE USUARIO ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';