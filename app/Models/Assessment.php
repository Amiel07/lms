<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_name',
        'direction',
        'items',
        'powerups',
        'course_id',
    ];

    protected $casts = [
        'items' => 'array',
    ];
}
