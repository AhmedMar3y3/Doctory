<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = 
    ['title',
    'image',
    'OldPrice',
    'NewPrice',
    'address',
    'specialization_id',
    'city_id',
    'admin_id',
    ];
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
