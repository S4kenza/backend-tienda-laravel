<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsCliente
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'No autenticado'], 401);
        }
        if ($user->rol !== 'cliente') {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        return $next($request);
    }
}
