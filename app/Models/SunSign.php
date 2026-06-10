<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SunSign extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'moon_sign_ids'];

    protected $casts = [
        'moon_sign_ids' => 'array',
    ];
}
