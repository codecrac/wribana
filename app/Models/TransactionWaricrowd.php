<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionWaricrowd extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function waricrowd(){
        return $this->belongsTo(Waricrowd::class,'id_waricrowd');
    }

    public function souteneur(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }

}
