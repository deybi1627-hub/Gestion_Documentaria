<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }

        $documentos = Documento::latest('fecha_publicacion')->take(3)->get();
        $totalDocumentos = Documento::count();
        
        return view('documentos.index', compact('documentos', 'totalDocumentos'));
    }

    public function portal(Request $request)
    {
        $query = Documento::query();

        if ($request->filled('search')) {
            $query->where('titulo', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $documentos = $query->latest('fecha_publicacion')->paginate(25); 
        
        return view('documentos.portal', compact('documentos'));
    }

    public function create()
    {
        return view('documentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'tipo' => 'required',
            'fecha_publicacion' => 'required|date',
            'archivo' => 'required|mimes:pdf|max:10240',
        ]);

        $path = $request->file('archivo')->store('documentos', 'public');

        Documento::create([
            'titulo' => $request->titulo,
            'tipo' => $request->tipo,
            'descripcion' => $request->descripcion,
            'archivo_path' => $path,
            'fecha_publicacion' => $request->fecha_publicacion, 
        ]);

        return redirect()->route('documentos.index')->with('success', 'Documento publicado con éxito.');
    }

    /**
     * NUEVO MÉTODO: Visualiza el archivo del portal de forma segura en internet.
     * Evita los problemas del enlace simbólico roto en servidores como Railway.
     */
    public function verArchivo(Documento $documento)
    {
        if (!Storage::disk('public')->exists($documento->archivo_path)) {
            abort(404, 'El archivo solicitado no existe en el servidor.');
        }

        $rutaAbsoluta = Storage::disk('public')->path($documento->archivo_path);

        return response()->file($rutaAbsoluta, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documento->titulo . '"'
        ]);
    }

    /**
     * Elimina el documento de la base de datos y el archivo físico.
     */
    public function destroy(Documento $documento)
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('documentos.index')->with('error', 'No tienes permisos para eliminar documentos.');
        }

        if ($documento->archivo_path && Storage::disk('public')->exists($documento->archivo_path)) {
            Storage::disk('public')->delete($documento->archivo_path);
        }

        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }
}