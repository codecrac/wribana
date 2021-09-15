<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tontine extends Model
{
    protected $guarded = [];

    public function createur(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }

    public function participants()
    {
        return $this->belongsToMany(Menbre::class);
    }
}
