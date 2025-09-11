<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeiculoArquivo extends Model
{
    use HasFactory;

    protected $fillable = ['veiculo_id', 'arquivo_nome_original', 'arquivo_caminho', 'tipo'];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class);
    }
}