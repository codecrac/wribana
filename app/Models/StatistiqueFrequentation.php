<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatistiqueFrequentation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $primaryKey = 'slug';
}
