<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteBancaire extends Model
{
    use HasFactory;
         protected $fillable = [
        'numero_compte',
        'solde',
        'solde_min',
        'status',
        'type',
        'taux_epargne',
        'frais_tenu_compte',
        'client_id'
        
    ];

    public function operation()
{
    return $this->hasMany(Operation::class);

}

}
