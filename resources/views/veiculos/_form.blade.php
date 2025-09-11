<form action="{{ isset($veiculo) ? route('veiculos.update', $veiculo) : route('veiculos.store') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @if(isset($veiculo))
        @method('PUT')
    @endif

    <h2 class="mb-4">{{ isset($veiculo) ? 'Editar Veículo' : 'Cadastrar Novo Veículo' }}</h2>

    <div class="row g-3">

        @if (!empty($veiculo->fotos))
            <div class="mb-3">
                <label class="form-label fw-semibold">Fotos já cadastradas:</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($veiculo->fotos as $index => $foto)
                        <div class="position-relative" style="width: 120px;">
                            <img src="{{ asset('storage/' . $foto) }}" class="img-thumbnail" style="width: 100%;">
                            <form action="{{ route('veiculos.removerArquivo', [$veiculo->id, 'foto', $index]) }}" method="POST"
                                class="position-absolute top-0 end-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Remover foto">×</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
        <!-- Upload Fotos -->
        <div class="col-12">
            <label for="fotos" class="form-label fw-semibold">Fotos do Veículo</label>
            <input type="file" name="fotos[]" id="fotos" class="form-control" multiple accept="image/jpeg,image/png">
            <div class="form-text">Aceitamos arquivos JPG e PNG. Você pode enviar múltiplas fotos.</div>
        </div>

        @if (!empty($veiculo->documentos))
            <div class="mb-3">
                <label class="form-label fw-semibold">Documentos já cadastrados:</label>
                <ul class="list-group">
                    @foreach($veiculo->documentos as $index => $documento)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ asset('storage/' . $documento) }}" target="_blank">
                                {{ basename($documento) }}
                            </a>
                            <form action="{{ route('veiculos.removerArquivo', [$veiculo->id, 'documento', $index]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Remover</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Upload Documentos -->
        <div class="col-12">
            <label for="documentos" class="form-label fw-semibold">Documentos do Veículo</label>
            <input type="file" name="documentos[]" id="documentos" class="form-control" multiple
                accept="image/*,application/pdf">
            <div class="form-text">Documentos digitalizados em PDF ou imagens.</div>
        </div>

        <!-- Placa -->
        <div class="col-md-4">
            <label for="placa" class="form-label fw-semibold">Placa</label>
            <input type="text" name="placa" id="placa" class="form-control"
                value="{{ old('placa', $veiculo->placa ?? '') }}" required>
        </div>

        <!-- Marca -->
        <div class="col-md-4">
            <label for="marca" class="form-label fw-semibold">Marca</label>
            <input type="text" name="marca" id="marca" class="form-control"
                value="{{ old('marca', $veiculo->marca ?? '') }}" required>
        </div>

        <!-- Modelo -->
        <div class="col-md-4">
            <label for="modelo" class="form-label fw-semibold">Modelo</label>
            <input type="text" name="modelo" id="modelo" class="form-control"
                value="{{ old('modelo', $veiculo->modelo ?? '') }}" required>
        </div>

        <!-- Cor -->
        <div class="col-md-4">
            <label for="cor" class="form-label fw-semibold">Cor</label>
            <input type="text" name="cor" id="cor" class="form-control" value="{{ old('cor', $veiculo->cor ?? '') }}">
        </div>

        <!-- Ano -->
        <div class="col-md-4">
            <label for="ano" class="form-label fw-semibold">Ano</label>
            <input type="number" name="ano" id="ano" class="form-control" value="{{ old('ano', $veiculo->ano ?? '') }}"
                required>
        </div>

        <label for="motorista_id" class="form-label fw-semibold">Motorista</label>
        <select name="motorista_id" id="motorista_id" class="form-select">
            <option value="">-- Selecione um motorista --</option>
            @foreach($motoristas as $motorista)
                <option value="{{ $motorista->id }}" {{ old('motorista_id', $veiculo->motorista_id ?? '') == $motorista->id ? 'selected' : '' }}>
                    {{ $motorista->nome }}
                </option>
            @endforeach
        </select>
        <!-- Status -->
        <div class="col-md-4">
            <label for="status" class="form-label fw-semibold">Status</label>
            <select name="status" id="status" class="form-select">
                @php
                    $statusOptions = ['ativo' => 'Ativo', 'manutencao' => 'Manutenção', 'inativo' => 'Inativo'];
                @endphp
                @foreach($statusOptions as $key => $label)
                    <option value="{{ $key }}" {{ (old('status', $veiculo->status ?? '') == $key) ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button type="submit" class="btn btn-success px-4">Salvar</button>
        <a href="{{ route('veiculos.index') }}" class="btn btn-secondary px-4">Cancelar</a>
    </div>
</form>