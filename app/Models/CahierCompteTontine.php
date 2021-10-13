<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierCompteTontine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tontine(){
        return $this->belongsTo(Tontine::class,'id_tontine');
    }
    
    public function beneficiaire(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }
}
