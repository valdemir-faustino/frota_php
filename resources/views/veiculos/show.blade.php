@extends('layouts.app')

@section('title', 'Detalhes do Veículo')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Detalhes do Veículo</h1>

    <div class="mb-3">
        <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar para a lista
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <h5 class="card-title">{{ $veiculo->marca }} {{ $veiculo->modelo }}</h5>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Placa:</strong> {{ $veiculo->placa }}<br>
                    <strong>Cor:</strong> {{ $veiculo->cor ?? 'Não informada' }}<br>
                    <strong>Ano:</strong> {{ $veiculo->ano }}<br>
                    <strong>Status:</strong>
                    <span class="badge 
                        @if($veiculo->status == 'ativo') bg-success
                        @elseif($veiculo->status == 'manutencao') bg-warning text-dark
                        @else bg-secondary
                        @endif">
                        {{ ucfirst($veiculo->status) }}
                    </span>
                </div>
                <div class="col-md-6">
                    <strong>Motorista Responsável:</strong><br>
                    @if($veiculo->motorista)
                        <ul class="list-unstyled">
                            <li><i class="bi bi-person-fill"></i> {{ $veiculo->motorista->nome }}</li>
                            <li><i class="bi bi-telephone-fill"></i> {{ $veiculo->motorista->telefone ?? 'Telefone não informado' }}</li>
                            <li><i class="bi bi-person-badge"></i> CPF: {{ $veiculo->motorista->cpf }}</li>
                        </ul>
                    @else
                        <span class="text-muted">Não atribuído</span>
                    @endif
                </div>
            </div>

            <hr>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Fotos:</strong><br>
                    @if($veiculo->fotos && count($veiculo->fotos))
                        <div class="d-flex flex-wrap gap-2 mt-2">
                            @foreach($veiculo->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            @endforeach
                        </div>
                    @else
                        <span class="text-muted">Nenhuma foto disponível</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <strong>Documentos:</strong><br>
                    @if($veiculo->documentos && count($veiculo->documentos))
                        <ul class="mt-2">
                            @foreach($veiculo->documentos as $index => $doc)
                                <li>
                                    <a href="{{ asset('storage/' . $doc) }}" target="_blank" class="text-decoration-none">
                                        📄 Documento {{ $index + 1 }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Nenhum documento disponível</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
