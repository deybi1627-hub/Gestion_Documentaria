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

        // Para la landing, solo mostramos los últimos 3
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
     * Elimina el documento de la base de datos y el archivo físico.
     */
    public function destroy(Documento $documento)
    {
        // Seguridad por Rol: Solo el administrador puede borrar
        if (auth()->user()->role !== 'admin') {
            return redirect()->route('documentos.index')->with('error', 'No tienes permisos para eliminar documentos.');
        }

        // 1. Borrar el archivo físico del disco público
        if ($documento->archivo_path && Storage::disk('public')->exists($documento->archivo_path)) {
            Storage::disk('public')->delete($documento->archivo_path);
        }

        // 2. Borrar el registro en la base de datos
        $documento->delete();

        return redirect()->route('documentos.index')->with('success', 'Documento eliminado correctamente.');
    }
}