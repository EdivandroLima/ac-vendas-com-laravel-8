<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoImport extends Model
{
    use HasFactory;
    
    protected $fillable= ['data', 'total_registros', 'user_id'];
}
