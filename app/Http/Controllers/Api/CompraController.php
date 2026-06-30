<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        // Trae todas las compras mostrando la información del proveedor
        $compras = Compra::with('proveedor')->get();
        return response()->json($compras, 200);
    }

    public function show(string $id)
    {
        // Trae una compra específica, su proveedor y los productos que se compraron
        $compra = Compra::with(['proveedor', 'productos'])->find($id);

        if (!$compra) {
            return response()->json(['message' => 'Compra no encontrada'], 404);
        }

        return response()->json($compra, 200);
    }
}