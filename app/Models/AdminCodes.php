<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminCodes extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_code_id',
        'code',
        'is_used'
        ];
    public function admin()
    {
        return $this->hasOne(Admin::class, 'admin_code_id');
    }}
