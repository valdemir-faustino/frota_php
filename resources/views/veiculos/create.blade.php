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

    <form action="{{ route('veiculos.store') }}" method="POST" enctype="multipart/form-data">
        @include('veiculos._form')
    </form>
</div>
@endsection
