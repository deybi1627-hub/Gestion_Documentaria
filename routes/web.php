<?php

use App\Http\Controllers\DocumentoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\MovimientoFinancieroController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

// =========================================================================
// RUTA DE EMERGENCIA: Limpieza de caché en producción (Railway)
// =========================================================================
Route::get('/limpiar-todo', function () {
    try {
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        
        return response()->json([
            'status' => 'success',
            'message' => '¡Toda la caché del sistema ha sido eliminada con éxito en Railway!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Hubo un error al limpiar la caché: ' . $e->getMessage()
        ], 500);
    }
});

// =========================================================================
// 1. RUTAS PÚBLICAS: El portal principal (Sin autenticación)
// =========================================================================
Route::get('/', [DocumentoController::class, 'index'])->name('welcome');
Route::get('/portal-documentos', [DocumentoController::class, 'portal'])->name('documentos.portal');
Route::get('/documentos', [DocumentoController::class, 'index'])->name('documentos.index');

// Visualización segura de los PDFs públicos del portal general (Evita enlaces simbólicos rotos)
Route::get('/portal-documentos/{documento}/ver', [DocumentoController::class, 'verArchivo'])->name('documentos.ver');

// =========================================================================
// 2. DASHBOARD: Pantalla de entrada post-login
// =========================================================================
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// =========================================================================
// 3. RUTAS PROTEGIDAS: Solo usuarios logueados
// =========================================================================
Route::middleware('auth')->group(function() {

    // === MESA DE PARTES / TRÁMITES (CIUDADANO) ===
    Route::get('/tramites', [TramiteController::class, 'index'])->name('tramites.index');
    Route::get('/tramites/crear', [TramiteController::class, 'create'])->name('tramites.create');
    Route::post('/tramites', [TramiteController::class, 'store'])->name('tramites.store');
    Route::get('/tramites/{tramite}', [TramiteController::class, 'show'])->name('tramites.show');
    Route::post('/tramites/movimiento/{movimiento}/voucher', [TramiteController::class, 'subirVoucher'])->name('tramites.voucher');
    
    // Descarga y visualización segura de documentos privados del trámite
    Route::get('/tramites/documentos/{documento}/descargar', [TramiteController::class, 'descargarDocumento'])->name('tramites.documento.descargar');
    
    // API para los requisitos del TUPA (Formulario dinámico JavaScript)
    Route::get('/api/tupa/{procedimientoTupa}/requisitos', [TramiteController::class, 'requisitosApi'])->name('tupa.requisitos');

    // === GESTIÓN DOCUMENTARIA GENERAL ===
    Route::get('/documentos/nuevo', [DocumentoController::class, 'create'])->name('documentos.create');
    Route::post('/documentos/guardar', [DocumentoController::class, 'store'])->name('documentos.store');
    Route::delete('/documentos/{documento}', [DocumentoController::class, 'destroy'])->name('documentos.destroy');

    // === SISTEMA FINANCIERO (CAJA / TESORERÍA) ===
    Route::middleware('can:admin-tramites')->prefix('finanzas')->name('finanzas.')->group(function() {
        Route::get('/', [MovimientoFinancieroController::class, 'index'])->name('index');
        Route::get('/crear', [MovimientoFinancieroController::class, 'create'])->name('create');
        Route::post('/', [MovimientoFinancieroController::class, 'store'])->name('store');
        Route::get('/reporte', [MovimientoFinancieroController::class, 'reporte'])->name('reporte');
        Route::get('/{movimiento}', [MovimientoFinancieroController::class, 'show'])->name('show');
        Route::get('/{movimiento}/editar', [MovimientoFinancieroController::class, 'edit'])->name('edit');
        Route::put('/{movimiento}', [MovimientoFinancieroController::class, 'update'])->name('update');
        
        // Descarga segura del voucher enviado por el usuario al área de finanzas
        Route::get('/{movimiento}/comprobante', [MovimientoFinancieroController::class, 'descargarComprobante'])->name('comprobante.descargar');
    });

    // === ARCHIVO CENTRAL / HISTÓRICO ===
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

    // === ADMINISTRACIÓN DE TRÁMITES (Solo Administradores / Evaluadores) ===
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