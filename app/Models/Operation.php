<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;
    protected $fillable = [
        'date', 
        'montant', 
        'type_operation', 
        'compte_bancaires_id'
    ];

        public function compteBancaires()
        {
            return $this->belongsTo(CompteBancaire::class);
        }
}
