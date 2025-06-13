<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{   protected $table = 'carritos';

    protected $fillable = [
        'user_id',
        'total',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito_productos')
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    public function total()
    {
        return $this->productos->sum(function ($producto) {
            return $producto->pivot->cantidad * $producto->precio;
        });
    }
    public function carritoProductos()
    {
        return $this->hasMany(CarritoProducto::class, 'carrito_id');
    }
}
