<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $guarded = [];

    public function tontine(){
        return $this->belongsTo(Tontine::class,'id_tontine');
    }

    public function menbre(){
        return $this->belongsTo(Menbre::class,'menbre_qui_invite');
    }
}
