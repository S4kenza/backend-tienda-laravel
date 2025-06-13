<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Carrito;
use App\Models\Pedido;
use App\Models\CarritoProducto;
use App\Models\PedidoProducto;

class Producto extends Model
{
    
     protected $fillable = [
        'titulo',
        'slug',
        'descripcion',
        'precio',
        'stock',
        'imagen',
    ];   

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    public function carrito()
    {
        return $this->belongsToMany(Carrito::class, 'carrito_productos')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class, 'pedido_productos');
    }
    public function carritoProductos()
    {
        return $this->hasMany(CarritoProducto::class, 'producto_id');
    }
    public function pedidosProductos()
    {
        return $this->hasMany(PedidoProducto::class, 'producto_id');
    }
}
