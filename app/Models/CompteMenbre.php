<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompteMenbre extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $primaryKey = "id_menbre";
}
