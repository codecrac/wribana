<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierRetraitSoldeMenbre extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function menbre(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }
}
