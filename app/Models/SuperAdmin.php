<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Change this


class SuperAdmin extends Authenticatable 
{
    use HasFactory;
    protected $fillable = ['email', 'password'];
   
}
