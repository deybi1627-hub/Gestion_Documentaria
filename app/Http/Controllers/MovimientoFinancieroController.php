<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MovimientoFinanciero;
use Illuminate\Support\Facades\DB;

class MovimientoFinancieroController extends Controller
{
    public function index(Request $request)
    {
        $query = MovimientoFinanciero::with(['tramite.procedimientoTupa']);

        // Filtros
        if ($request->tipo) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->fecha_desde) {
            $query->whereDate('fecha_transaccion', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('fecha_transaccion', '<=', $request->fecha_hasta);
        }

        $movimientos = $query->orderBy('fecha_transaccion', 'desc')->paginate(20);

        // Calcular resumen financiero
        $resumen = [
            'total_ingresos' => MovimientoFinanciero::ingresos()->pagados()->sum('monto'),
            'total_egresos' => MovimientoFinanciero::egresos()->pagados()->sum('monto'),
            'saldo' => 0,
            'pendientes' => MovimientoFinanciero::where('estado', 'pendiente')->sum('monto')
        ];
        $resumen['saldo'] = $resumen['total_ingresos'] - $resumen['total_egresos'];

        return view('finanzas.index', compact('movimientos', 'resumen'));
    }

    public function create()
    {
        return view('finanzas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ingreso,egreso',
            'categoria' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'required|string|max:500',
            'estado' => 'required|in:pendiente,pagado,cancelado',
            'fecha_transaccion' => 'required|date',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('comprobante')) {
            $data['comprobante_path'] = $request->file('comprobante')->store('comprobantes', 'public');
        }

        MovimientoFinanciero::create($data);

        return redirect()->route('finanzas.index')->with('success', 'Movimiento financiero registrado');
    }

    public function show(MovimientoFinanciero $movimiento)
    {
        return view('finanzas.show', compact('movimiento'));
    }

    public function edit(MovimientoFinanciero $movimiento)
    {
        return view('finanzas.edit', compact('movimiento'));
    }

    public function update(Request $request, MovimientoFinanciero $movimiento)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,pagado,cancelado',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['estado']);

        if ($request->hasFile('comprobante')) {
            $data['comprobante_path'] = $request->file('comprobante')->store('comprobantes', 'public');
        }

        $movimiento->update($data);

        return redirect()->route('finanzas.index')->with('success', 'Movimiento actualizado');
    }

    public function reporte(Request $request)
    {
        $fechaDesde = $request->fecha_desde ?? now()->startOfMonth();
        $fechaHasta = $request->fecha_hasta ?? now()->endOfMonth();

        $movimientos = MovimientoFinanciero::whereBetween('fecha_transaccion', [$fechaDesde, $fechaHasta])
                                          ->orderBy('fecha_transaccion')
                                          ->get();

        $resumen = [
            'ingresos' => $movimientos->where('tipo', 'ingreso')->where('estado', 'pagado')->sum('monto'),
            'egresos' => $movimientos->where('tipo', 'egreso')->where('estado', 'pagado')->sum('monto'),
            'pendientes' => $movimientos->where('estado', 'pendiente')->sum('monto'),
            'periodo' => $fechaDesde->format('d/m/Y') . ' - ' . $fechaHasta->format('d/m/Y')
        ];
        $resumen['saldo'] = $resumen['ingresos'] - $resumen['egresos'];

        return view('finanzas.reporte', compact('movimientos', 'resumen'));
    }
}
