<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaisseTontine extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $primaryKey = 'id_tontine';

    public function menbre_qui_prend(){
        return $this->belongsTo(Menbre::class,'id_menbre_qui_prend');
    }
}
