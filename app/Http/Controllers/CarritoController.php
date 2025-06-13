<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrito;

class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $carrito = $request->user()->carrito;
        return response()->json($carrito, 200);
    }

    public function add(Request $request, $productoId)
    {
        $producto = $request->user()->carrito()->attach($productoId);
        return response()->json(['message' => 'Producto agregado al carrito'], 201);
    }

    public function remove(Request $request, $productoId)
    {
        $request->user()->carrito()->detach($productoId);
        return response()->json(['message' => 'Producto eliminado del carrito'], 200);
    }    
}
