<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'name',
        'image',
        'price',
        'city_id',
        'specialization_id',
        'waiting_time',
        'address',
        'images',
        'details',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
}
