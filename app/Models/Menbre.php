<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menbre extends Model
{
    protected $guarded = [];

    public function tontines()
    {
        return $this->belongsToMany(Tontine::class);
    }
}
