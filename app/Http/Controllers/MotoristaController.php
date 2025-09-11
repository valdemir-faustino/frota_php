<?php

namespace App\Http\Controllers;

use App\Models\Motorista;
use Illuminate\Http\Request;

class MotoristaController extends Controller
{
    public function index()
    {
        $motoristas = Motorista::all();
        return view('motoristas.index', compact('motoristas'));
    }

    public function create()
    {
        return view('motoristas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:motoristas,cpf',
            'telefone' => 'nullable',
        ]);

        Motorista::create($request->all());

        return redirect()->route('motoristas.index')->with('success', 'Motorista cadastrado com sucesso');
    }

    public function edit(Motorista $motorista)
    {
        return view('motoristas.edit', compact('motorista'));
    }

    public function update(Request $request, Motorista $motorista)
    {
        $request->validate([
            'nome' => 'required',
            'cpf' => 'required|unique:motoristas,cpf,' . $motorista->id,
            'telefone' => 'nullable',
        ]);

        $motorista->update($request->all());

        return redirect()->route('motoristas.index')->with('success', 'Motorista atualizado com sucesso');
    }

    public function destroy(Motorista $motorista)
    {
        $motorista->delete();
        return redirect()->route('motoristas.index')->with('success', 'Motorista removido com sucesso');
    }
}