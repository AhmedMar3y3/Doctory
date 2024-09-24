<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable = 
    [
        'name',
        'image',
        'phone',
        'admin_id',
        'superadmin_id',
    ];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
