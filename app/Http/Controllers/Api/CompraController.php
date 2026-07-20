<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        $compras = Compra::with('proveedor')->get();
        return response()->json($compras, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
        ]);

        $compra = Compra::create($request->all());

        return response()->json([
            'message' => 'Compra registrada exitosamente',
            'data' => $compra
        ], 201);
    }

    public function show(string $id)
    {
        $compra = Compra::with(['proveedor', 'productos'])->find($id);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        return response()->json($compra, 200);
    }

    public function update(Request $request, string $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        $request->validate([
            'proveedor_id' => 'required|integer|exists:proveedores,id',
            'fecha' => 'required|date',
            'total' => 'required|numeric|min:0',
        ]);

        $compra->update($request->all());

        return response()->json([
            'message' => 'Compra actualizada exitosamente',
            'data' => $compra
        ], 200);
    }

    public function destroy(string $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        $compra->delete();

        return response()->json(['message' => 'Compra eliminada correctamente'], 200);
    }
}