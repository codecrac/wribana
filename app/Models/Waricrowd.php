<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waricrowd extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function categorie(){
        return $this->belongsTo(CategorieWaricrowd::class,'id_categorie');
    }

    public function caisse(){
        return $this->hasOne(CaisseWaricrowd::class,'id_waricrowd');
    }

    public function transactions(){
        return $this->hasMany(TransactionWaricrowd::class,'id_waricrowd');
    }

    public function createur(){
        return $this->belongsTo(Menbre::class,'id_menbre')->with('devise_choisie');
    }
}
