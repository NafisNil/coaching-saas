<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['student_id', 'exam_id', 'institution_id', 'marks_obtained', 'grade', 'remarks', 'rank'])]

class ExamResult extends Model
{
    //
    protected $casts = [
        'marks_obtained' => 'decimal:2',
        'percentage' => 'decimal:2'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
