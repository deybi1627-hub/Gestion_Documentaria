<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Archivo;
use App\Models\Documento;

class ArchivoController extends Controller
{
    public function index(Request $request)
    {
        $query = Archivo::with(['documento']);

        // Filtros
        if ($request->anio) {
            $query->where('anio', $request->anio);
        }

        if ($request->departamento) {
            $query->where('departamento', $request->departamento);
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        $archivos = $query->orderBy('fecha_archivacion', 'desc')->paginate(20);

        // Estadísticas
        $estadisticas = [
            'total_archivados' => Archivo::count(),
            'prestados' => Archivo::where('estado', 'prestado')->count(),
            'por_destruir' => Archivo::where('fecha_destruccion', '<=', now())->count(),
            'departamentos' => Archivo::distinct('departamento')->pluck('departamento')->filter()
        ];

        return view('archivos.index', compact('archivos', 'estadisticas'));
    }

    public function create()
    {
        $documentos = Documento::whereDoesntHave('archivo')->get();
        return view('archivos.create', compact('documentos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'documento_id' => 'required|exists:documentos,id',
            'ubicacion_fisica' => 'nullable|string|max:255',
            'departamento' => 'required|string|max:255',
            'notas' => 'nullable|string|max:500'
        ]);

        $documento = Documento::findOrFail($request->documento_id);

        // Verificar que no esté ya archivado
        if ($documento->archivo) {
            return back()->with('error', 'Este documento ya está archivado');
        }

        $codigoArchivo = 'ARCH-' . date('Y') . '-' . strtoupper(substr($request->departamento, 0, 3)) . '-' . str_pad(Archivo::count() + 1, 4, '0', STR_PAD_LEFT);

        Archivo::create([
            'documento_id' => $request->documento_id,
            'codigo_archivo' => $codigoArchivo,
            'ubicacion_fisica' => $request->ubicacion_fisica,
            'anio' => date('Y'),
            'departamento' => $request->departamento,
            'estado' => 'archivado',
            'fecha_archivacion' => now(),
            'fecha_destruccion' => now()->addYears(7), // Política de retención de 7 años
            'notas' => $request->notas
        ]);

        return redirect()->route('archivos.index')->with('success', 'Documento archivado exitosamente');
    }

    public function show(Archivo $archivo)
    {
        $archivo->load(['documento.tramite']);
        return view('archivos.show', compact('archivo'));
    }

    public function edit(Archivo $archivo)
    {
        return view('archivos.edit', compact('archivo'));
    }

    public function update(Request $request, Archivo $archivo)
    {
        $request->validate([
            'ubicacion_fisica' => 'nullable|string|max:255',
            'estado' => 'required|in:archivado,prestado,destruido',
            'notas' => 'nullable|string|max:500'
        ]);

        $archivo->update($request->only(['ubicacion_fisica', 'estado', 'notas']));

        return redirect()->route('archivos.index')->with('success', 'Archivo actualizado');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'codigo_archivo' => 'required|string'
        ]);

        $archivo = Archivo::where('codigo_archivo', $request->codigo_archivo)
                         ->with(['documento.tramite'])
                         ->first();

        if (!$archivo) {
            return back()->with('error', 'Archivo no encontrado');
        }

        return view('archivos.show', compact('archivo'));
    }

    public function documentosPorDestruir()
    {
        $archivos = Archivo::where('fecha_destruccion', '<=', now())
                          ->where('estado', '!=', 'destruido')
                          ->with(['documento'])
                          ->get();

        return view('archivos.por-destruir', compact('archivos'));
    }

    public function destruir(Archivo $archivo)
    {
        if (!$archivo->debeDestruirse()) {
            return back()->with('error', 'Este documento no puede ser destruido aún');
        }

        $archivo->update([
            'estado' => 'destruido',
            'notas' => ($archivo->notas ? $archivo->notas . ' | ' : '') . 'Destruido el ' . now()->format('d/m/Y')
        ]);

        return back()->with('success', 'Documento marcado como destruido');
    }
}
