<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategorieWaricrowd extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function waricrods(){
        return $this->hasMany(Waricrowd::class,'id_categorie');
    }

    public function waricrowds_valider(){
        return $this->hasMany(Waricrowd::class,'id_categorie')->where('etat','=','valider')
            ->orWhere('etat','=','terminer')->orderBy('id','desc');
    }
}
