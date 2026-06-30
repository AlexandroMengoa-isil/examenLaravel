<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marca;

class MarcaController extends Controller
{
    public function index()
    {

        return response()->json(Marca::with('productos')->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate(['nombre' => 'required|string|max:100|unique:marcas']);
        $marca = Marca::create($request->all());
        return response()->json(['message' => 'Marca registrada', 'data' => $marca], 201);
    }

    public function show(string $id)
    {
        $marca = Marca::with('productos')->find($id);
        if (!$marca) return response()->json(['message' => 'No encontrada'], 404);
        return response()->json($marca, 200);
    }

    public function update(Request $request, string $id)
    {
        $marca = Marca::find($id);
        if (!$marca) return response()->json(['message' => 'No encontrada'], 404);
        
        $request->validate(['nombre' => 'required|string|max:100|unique:marcas,nombre,'.$id]);
        $marca->update($request->all());
        return response()->json(['message' => 'Marca actualizada', 'data' => $marca], 200);
    }

    public function destroy(string $id)
    {
        $marca = Marca::find($id);
        if (!$marca) return response()->json(['message' => 'No encontrada'], 404);
        $marca->delete();
        return response()->json(['message' => 'Marca eliminada'], 200);
    }
}