@csrf

<div class="mb-3">
    <label for="nome" class="form-label">Nome</label>
    <input type="text" name="nome" id="nome" class="form-control" value="{{ old('nome', $motorista->nome ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input type="text" name="cpf" id="cpf" class="form-control" value="{{ old('cpf', $motorista->cpf ?? '') }}" required>
</div>

<div class="mb-3">
    <label for="telefone" class="form-label">Telefone</label>
    <input type="text" name="telefone" id="telefone" class="form-control" value="{{ old('telefone', $motorista->telefone ?? '') }}">
</div>

<button type="submit" class="btn btn-success">Salvar</button>
<a href="{{ route('motoristas.index') }}" class="btn btn-secondary">Cancelar</a>
