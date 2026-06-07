<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory; //esto por lo que entendi es para decirle donde esta la herramienta y asi no se loquee buscandola
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory; //esto lo vi en su ejemplo y investigando me sirve para generar datos falsos de forma automatica para llenar con datos mi base de datos
                    // lo agregue por si acasito

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}