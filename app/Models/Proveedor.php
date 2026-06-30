<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'telefono'];

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}