<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointsUsage extends Model
{
    use HasFactory;
    protected $table = 'points_usage';

    protected $fillable = [
        'student_id',
        'assessment_id',
        'used_points',
    ];
}
