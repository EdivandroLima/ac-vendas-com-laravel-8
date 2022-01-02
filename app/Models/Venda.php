<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;

    protected $fillable = ['data', 'valor_venda', 'valor_projetado', 'user_id'];

    protected $casts = [
        'data' => 'date:d/m/Y',
    ];
    
}
