<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueModifProfilMembre extends Model
{
    use HasFactory;
    
    public function menbre(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }
    
}
