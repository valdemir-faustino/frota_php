@extends('layouts.app')

@section('content')
<div class="container">
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('veiculos.update', $veiculo) }}" method="POST">
        @method('PUT')
        @include('veiculos._form')
    </form>
</div>
@endsection