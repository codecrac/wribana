<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menbre extends Model
{
    use HasFactory;
    protected $guarded = [];
//    protected $dates = ['created_at', 'updated_at', 'date_derniere_visite'];

    public function devise_choisie()
    {
        return $this->belongsTo(Devise::class,'devise');
    }
    
    public function tontines()
    {
        return $this->belongsToMany(Tontine::class)->orderBy('id','desc');
    }

    public function mes_tontines_pour_mobile()
    {
        // return $this->belongsToMany(Tontine::class)->with('caisse')->with('createur')->with('participants')->orderBy('id','desc');
        return $this->belongsToMany(Tontine::class)->with('createur')->orderBy('id','desc');
    }

    public function compte(){
        return $this->hasOne(CompteMenbre::class,'id_menbre');
    }
    
    public function historique_retraits()
    {
        return $this->hasMany(CahierRetraitSoldeMenbre::class,'id_menbre')->orderBy('id','desc');
    }


    public function historique_virement_tontine(){
        return $this->hasMany(CahierCompteTontine::class,'id_menbre');
    }

    public function  mes_waricrowd(){
        return $this->hasMany(Waricrowd::class,'id_menbre')->orderBy('id','desc');
    }

    public function  mes_waricrowd_pour_mobile(){
        return $this->hasMany(Waricrowd::class,'id_menbre')->with('categorie')->with('createur')->with('caisse')->orderBy('id','desc');
    }

    public function projets_soutenus(){
        return $this->belongsToMany(Waricrowd::class,'waricrowd_menbres');
    }
}
