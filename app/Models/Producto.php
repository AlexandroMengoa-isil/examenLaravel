<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'productos';
    protected $fillable = ['categoria_id', 'marca_id', 'nombre', 'precio', 'stock'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class, 'compra_producto', 'producto_id', 'compra_id')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }
}