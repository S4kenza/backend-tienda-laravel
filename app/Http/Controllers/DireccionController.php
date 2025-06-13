<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;

class DireccionController extends Controller
{
    public function index(Request $request)
    {
        $direcciones = $request->user()->direcciones;
        return response()->json($direcciones, 200);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'direccion' => 'required|string|max:255',
        'ciudad' => 'required|string|max:100',
        'provincia' => 'required|string|max:100',
        'telefono' => 'required|string|max:20',
    ]);

    $direccion = Direccion::create([
        'user_id' => $request->user()->id,
        ...$validated
    ]);

    return response()->json(['message' => 'Dirección creada con éxito', 'direccion' => $direccion], 201);
}

    public function update(Request $request, $id)
    {
        $direccion = Direccion::findOrFail($id);
        if ($direccion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $direccion->update($request->all());
        return response()->json(['message' => 'Dirección actualizada con éxito'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $direccion = Direccion::findOrFail($id);
        if ($direccion->user_id !== $request->user()->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $direccion->delete();
        return response()->json(['message' => 'Dirección eliminada con éxito'], 200);
    }
}
