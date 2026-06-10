<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AstrologyReport extends Model
{
     protected $table = 'astrology_reports';

     protected $casts = [
        'rasi' => 'array',
        'navamsa' => 'array'
    ];
}