<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // El 'with' hace la magia: trae la categoría y marca automáticamente
        $productos = Producto::with(['categoria', 'marca'])->get();
        return response()->json($productos, 200);
    }

    public function show(string $id)
    {
        // Trae un producto específico con su categoría, marca y las compras asociadas
        $producto = Producto::with(['categoria', 'marca', 'compras'])->find($id);

        if (!$producto) {
            return response()->json(['message' => 'Producto no encontrado'], 404);
        }

        return response()->json($producto, 200);
    }
}