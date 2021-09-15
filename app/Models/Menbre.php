<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menbre extends Model
{
    protected $guarded = [];

    public function tontines()
    {
        return $this->belongsToMany(Tontine::class);
    }

    public function compte(){
        return $this->hasOne(CompteMenbre::class,'id_menbre');
    }

    public function historique_virement_tontine(){
        return $this->hasMany(CahierCompteTontine::class,'id_menbre');
    }
}
