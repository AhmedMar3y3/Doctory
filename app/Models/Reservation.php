<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Reservation extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'day', 
        'time', 
        'doctor_id'
    ];
    protected $dates = ['expires_at'];


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
