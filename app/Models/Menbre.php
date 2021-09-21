<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menbre extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tontines()
    {
        return $this->belongsToMany(Tontine::class)->orderBy('id','desc');
    }

    public function compte(){
        return $this->hasOne(CompteMenbre::class,'id_menbre');
    }

    public function historique_virement_tontine(){
        return $this->hasMany(CahierCompteTontine::class,'id_menbre');
    }

    public function  mes_waricrowd(){
        return $this->hasMany(Waricrowd::class,'id_menbre')->orderBy('id','desc');
    }

    public function projets_soutenus(){
        return $this->belongsToMany(Waricrowd::class,'waricrowd_menbres');
    }
}
