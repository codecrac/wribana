<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahierCompteTontine extends Model
{
    use HasFactory;
    public function tontine(){
        return $this->belongsTo(Tontine::class,'id_tontine');
    }
}
