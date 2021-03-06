<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tontine(){
        return $this->belongsTo(Tontine::class,'id_tontine');
    }

    public function menbre_inviteur(){
        return $this->belongsTo(Menbre::class,'menbre_qui_invite');
    }
}
