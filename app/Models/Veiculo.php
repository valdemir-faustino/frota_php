<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
    'placa',
    'marca',
    'modelo',
    'cor',
    'ano',
    'status',
    'motorista_id',  // <- adicionado
    'fotos',
    'documentos',
];

    public function arquivos()
    {
        return $this->hasMany(VeiculoArquivo::class);
    }
    protected $casts = [
        'fotos' => 'array',
        'documentos' => 'array',
    ];

    public function motorista()
    {
        return $this->belongsTo(Motorista::class);
    }

}