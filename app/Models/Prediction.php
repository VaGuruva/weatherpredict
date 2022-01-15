<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'scale', 
        'city',
        'date',
        'value',
        'time'
    ];

    public function partners()
    {
        return $this->belongsToMany(Partner::class);
    }
}
