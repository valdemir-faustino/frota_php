<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motorista extends Model
{

    protected $fillable = [
        'nome',
        'cpf',
        'telefone',
    ];
    use HasFactory;
    public function veiculos()
    {
        return $this->hasMany(Veiculo::class);
    }
}
