<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{
    public function index()
    {
        $veiculos = Veiculo::with('motorista')->get();
        return view('veiculos.index', compact('veiculos'));
    }

    public function create()
    {
        $motoristas = Motorista::all();
        return view('veiculos.create', compact('motoristas'));
    }

    public function store(Request $request)
    {
        $fotos = array_filter($request->file('fotos') ?? []);
        $documentos = array_filter($request->file('documentos') ?? []);

        $request->merge([
            'fotos' => $fotos,
            'documentos' => $documentos,
        ]);

        $request->validate([
            'placa' => 'required|unique:veiculos,placa',
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'motorista_id' => 'nullable|exists:motoristas,id',
            'status' => 'required|in:ativo,manutencao,inativo',
            'fotos.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'documentos.*' => 'file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        if ($request->status === 'ativo' && empty($request->motorista_id)) {
            return back()->withErrors(['motorista_id' => 'Um veículo ativo deve ter um motorista atribuído.'])->withInput();
        }

        $fotosPaths = [];
        foreach ($fotos as $foto) {
            $path = $foto->store('public/veiculos/fotos');
            $fotosPaths[] = str_replace('public/', '', $path);
        }

        $documentosPaths = [];
        foreach ($documentos as $documento) {
            $path = $documento->store('public/veiculos/documentos');
            $documentosPaths[] = str_replace('public/', '', $path);
        }

        Veiculo::create([
            'placa' => $request->placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'cor' => $request->cor,
            'ano' => $request->ano,
            'status' => $request->status,
            'motorista_id' => $request->motorista_id,
            'fotos' => $fotosPaths,
            'documentos' => $documentosPaths,
        ]);

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso!');
    }

    public function edit(Veiculo $veiculo)
    {
        $motoristas = Motorista::all();
        return view('veiculos.edit', compact('veiculo', 'motoristas'));
    }

    public function update(Request $request, Veiculo $veiculo)
    {
        $fotos = array_filter($request->file('fotos') ?? []);
        $documentos = array_filter($request->file('documentos') ?? []);

        $request->merge([
            'fotos' => $fotos,
            'documentos' => $documentos,
        ]);

        $request->validate([
            'placa' => 'required|unique:veiculos,placa,' . $veiculo->id,
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'motorista_id' => 'nullable|exists:motoristas,id',
            'status' => 'required|in:ativo,manutencao,inativo',
            'fotos.*' => 'file|image|mimes:jpeg,png,jpg|max:2048',
            'documentos.*' => 'file|mimes:pdf,jpeg,png,jpg|max:5120',
        ]);

        if ($request->status === 'ativo' && empty($request->motorista_id)) {
            return back()->withErrors(['motorista_id' => 'Um veículo ativo deve ter um motorista atribuído.'])->withInput();
        }

        // Atualiza os dados principais
        $veiculo->update([
            'placa' => $request->placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'cor' => $request->cor,
            'ano' => $request->ano,
            'status' => $request->status,
            'motorista_id' => $request->motorista_id,
        ]);

        // Atualiza as fotos (se houver novas)
        if (count($fotos)) {
            $fotosPaths = $veiculo->fotos ?? [];
            foreach ($fotos as $foto) {
                $path = $foto->store('public/veiculos/fotos');
                $fotosPaths[] = str_replace('public/', '', $path);
            }
            $veiculo->fotos = $fotosPaths;
        }

        // Atualiza os documentos (se houver novos)
        if (count($documentos)) {
            $documentosPaths = $veiculo->documentos ?? [];
            foreach ($documentos as $documento) {
                $path = $documento->store('public/veiculos/documentos');
                $documentosPaths[] = str_replace('public/', '', $path);
            }
            $veiculo->documentos = $documentosPaths;
        }

        $veiculo->save();

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso!');
    }

    public function destroy(Veiculo $veiculo)
    {
        // Se quiser deletar arquivos do disco, descomente abaixo
        /*
        foreach ($veiculo->fotos ?? [] as $foto) {
            Storage::delete('public/' . $foto);
        }
        foreach ($veiculo->documentos ?? [] as $doc) {
            Storage::delete('public/' . $doc);
        }
        */

        $veiculo->delete();

        return redirect()->route('veiculos.index')->with('success', 'Veículo removido com sucesso!');
    }

    public function show(Veiculo $veiculo)
    {
        return view('veiculos.show', compact('veiculo'));
    }

    public function removerArquivo(Veiculo $veiculo, $tipo, $index)
    {
        if (!in_array($tipo, ['foto', 'documento'])) {
            abort(400, 'Tipo de arquivo inválido.');
        }

        $campo = $tipo === 'foto' ? 'fotos' : 'documentos';
        $arquivos = $veiculo->$campo ?? [];

        if (!isset($arquivos[$index])) {
            return redirect()->back()->with('error', 'Arquivo não encontrado.');
        }

        // Deleta do disco
        Storage::delete('public/' . $arquivos[$index]);

        // Remove do array e reindexa
        unset($arquivos[$index]);
        $veiculo->$campo = array_values($arquivos);
        $veiculo->save();

        return redirect()->back()->with('success', ucfirst($tipo) . ' removido com sucesso.');
    }
}