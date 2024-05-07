<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAnswers extends Model
{
    use HasFactory;

    protected $fillable = [
        'answers',
        'assessment_id',
        'student_id',
        'score',
    ];

    protected $casts = [
        'answers' => 'array',
    ];
}
