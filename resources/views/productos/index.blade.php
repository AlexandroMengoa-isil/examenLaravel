@extends('layouts.app')

@section('content')
<div class="container shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <div class="d-flex justify-content-between">
        <h2>Productos</h2>
        <button class="btn btn-outline-primary" onclick="nuevoProducto()" data-bs-toggle="modal" data-bs-target="#modalProducto">
            Nuevo producto
        </button>
    </div>
    @include('productos.tabla')
</div>

@include('productos.modal')
@endsection

@section('scripts')
@include('productos.scripts')
@endsection
