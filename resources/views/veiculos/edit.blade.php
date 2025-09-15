@extends('layouts.app')

@section('content')
<x _alert />
<div class="container">
    <form action="{{ route('veiculos.update', $veiculo) }}" method="POST">
        @method('PUT')
        @include('veiculos._form')
    </form>
</div>
@endsection