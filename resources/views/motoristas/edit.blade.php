@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2>Editar Motorista</h2>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $erro)
            <li>{{ $erro }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('motoristas.update', $motorista) }}" method="POST">
        @csrf
        @method('PUT')
        @include('motoristas._form')
    </form>
</div>
@endsection
