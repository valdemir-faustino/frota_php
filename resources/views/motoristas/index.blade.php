@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Motoristas</h1>
        <a href="{{ route('motoristas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Motorista
        </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($motoristas as $motorista)
                <tr>
                    <td>{{ $motorista->nome }}</td>
                    <td>{{ $motorista->cpf }}</td>
                    <td>{{ $motorista->telefone }}</td>
                    <td>
                        <a href="{{ route('motoristas.edit', $motorista) }}" class="btn btn-sm btn-warning me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('motoristas.destroy', $motorista) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este motorista?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Nenhum motorista cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
