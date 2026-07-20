@extends('layouts.app')

@section('content')
<div class="container shadow-lg p-3 mb-5 bg-body-tertiary rounded">
    <div class="d-flex justify-content-between">
        <h2>Marcas</h2>
        <button class="btn btn-outline-primary" onclick="nuevaMarca()" data-bs-toggle="modal" data-bs-target="#modalMarca">
            Nueva marca
        </button>
    </div>
    @include('marcas.tabla')
</div>

@include('marcas.modal')
@endsection

@section('scripts')
@include('marcas.scripts')
@endsection
