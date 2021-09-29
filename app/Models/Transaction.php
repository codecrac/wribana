<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['id_tontine','id_menbre','id_menbre_qui_prend','montant'];

    public function tontine(){
        return $this->belongsTo(Tontine::class,'id_tontine');
    }

    public function cotiseur(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }

    public function menbre_qui_prend(){
        return $this->belongsTo(Menbre::class,'id_menbre_qui_prend')->orderBy('id','desc');
    }
}
