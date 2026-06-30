<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $fillable = ['proveedor_id', 'fecha', 'total'];

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'compra_producto', 'compra_id', 'producto_id')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }
}