@extends('layouts.app')

@section('content')
<div class="container shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <div class="d-flex justify-content-between">
        <h2>Proveedores</h2>
        <button class="btn btn-outline-primary" onclick="nuevoProveedor()" data-bs-toggle="modal" data-bs-target="#modalProveedor">
            Nuevo proveedor
        </button>
    </div>
    @include('proveedores.tabla')
</div>

@include('proveedores.modal')
@endsection

@section('scripts')
@include('proveedores.scripts')
@endsection
