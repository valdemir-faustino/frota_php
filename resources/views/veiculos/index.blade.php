@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0">Cadastro de Veículos</h1>
            <a href="{{ route('veiculos.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Novo Veículo
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Placa</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cor</th>
                        <th>Ano</th>
                        <th>Status</th>
                        <th style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veiculos as $veiculo)
                        <tr>
                            <td>{{ $veiculo->placa }}</td>
                            <td>{{ $veiculo->marca }}</td>
                            <td>{{ $veiculo->modelo }}</td>
                            <td>{{ $veiculo->cor }}</td>
                            <td>{{ $veiculo->ano }}</td>

                            {{-- STATUS --}}
                            <td>
                                @php
                                    $statusClasses = [
                                        'ativo' => 'badge bg-success',
                                        'manutencao' => 'badge bg-warning text-dark',
                                        'inativo' => 'badge bg-secondary'
                                    ];
                                @endphp
                                <span class="{{ $statusClasses[$veiculo->status] ?? 'badge bg-info' }}">
                                    {{ ucfirst($veiculo->status) }}
                                </span>
                            </td>

                            
                            {{-- AÇÕES --}}
                            <td>

                                <a href="{{ route('veiculos.show', $veiculo) }}" class="btn btn-sm btn-info text-white me-1">
                                    <i class="bi bi-eye"></i> Detalhes
                                </a>
                                <a href="{{ route('veiculos.edit', $veiculo) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil-square"></i> Editar
                                </a>
                                <form action="{{ route('veiculos.destroy', $veiculo) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Tem certeza que deseja excluir este veículo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">Nenhum veículo cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection