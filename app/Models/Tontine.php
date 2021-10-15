<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function createur(){
        return $this->belongsTo(Menbre::class,'id_menbre')->with('devise_choisie');;
    }

    public function caisse()
    {
        return $this->hasOne(CaisseTontine::class,'id_tontine')->with("menbre_qui_prend");
    }

    public function participants()
    {
        return $this->belongsToMany(Menbre::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class,'id_tontine');
    }

}
