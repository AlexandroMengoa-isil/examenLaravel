@extends('layouts.app')

@section('content')
<div class="container shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <div class="d-flex justify-content-between">
        <h2>Compras</h2>
        <button class="btn btn-outline-primary" onclick="nuevaCompra()" data-bs-toggle="modal" data-bs-target="#modalCompra">
            Nueva compra
        </button>
    </div>
    @include('compras.tabla')
</div>

@include('compras.modal')
@endsection

@section('scripts')
@include('compras.scripts')
@endsection
