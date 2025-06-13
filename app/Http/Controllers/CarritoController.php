<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
    $carrito = Carrito::where('user_id', $request->user()->id)
            ->where('estado', 'activo')
            ->with('productos')
            ->first();

        if (!$carrito) {
            $carrito = Carrito::create([
                'user_id' => $request->user()->id,
                'estado' => 'activo',
            ]);
            // Asegúrate de cargar la relación productos (vacía)
            $carrito->load('productos');
        }

        return response()->json($carrito,200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrito_id' => 'required|exists:carritos,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

    $carrito = Carrito::findOrFail($validated['carrito_id']);

    foreach ($validated['productos'] as $producto) {
        // Agrega o actualiza la cantidad del producto en el carrito
        $carrito->productos()->syncWithoutDetaching([
            $producto['id'] => ['cantidad' => $producto['cantidad']]
        ]);
    }

    // Si necesitas guardar la dirección en el carrito (opcional)
    if (isset($validated['direccion_id'])) {
        $carrito->direccion_id = $validated['direccion_id'];
        $carrito->save();
    }

    // Retorna el carrito actualizado con productos
    return response()->json($carrito->load('productos'), 200);
}

    public function remove(Request $request, $productoId)
    {
        $request->user()->carrito()->detach($productoId);
        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }    
}
