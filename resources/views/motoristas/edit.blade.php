@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Editar Motorista</h2>
    <x _alert />
    <form action="{{ route('motoristas.update', $motorista) }}" method="POST">
        @csrf
        @method('PUT')
        @include('motoristas._form')
    </form>
</div>
@endsection
