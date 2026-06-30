<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public function index()
    {
        
        return response()->json(Proveedor::with('compras')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);
        $proveedor = Proveedor::create($request->all());
        return response()->json(['message' => 'Proveedor registrado', 'data' => $proveedor], 201);
    }

    public function show(string $id)
    {
        $proveedor = Proveedor::with('compras')->find($id);
        if (!$proveedor) return response()->json(['message' => 'No encontrado'], 404);
        return response()->json($proveedor, 200);
    }

    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) return response()->json(['message' => 'No encontrado'], 404);

        $request->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20'
        ]);
        $proveedor->update($request->all());
        return response()->json(['message' => 'Proveedor actualizado', 'data' => $proveedor], 200);
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedor::find($id);
        if (!$proveedor) return response()->json(['message' => 'No encontrado'], 404);
        $proveedor->delete();
        return response()->json(['message' => 'Proveedor eliminado'], 200);
    }
}