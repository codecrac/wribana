<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTransfertWaribank extends Model
{
    public $guarded = [];

    public function expediteur(){
        return $this->belongsTo(Menbre::class,'id_menbre');
    }

    public function destinataire(){
        return $this->belongsTo(Menbre::class,'id_destinataire');
    }
}
