<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function cotiseur(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }
}
