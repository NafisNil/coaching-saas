<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['institution_id', 'subject_id', 'batch_id', 'title', 'total_marks', 'duration_minutes', 'exam_date', 'type', 'status'])]
class Exam extends Model
{
    use BelongsToInstitution;
    protected $casts = [
        'total_marks' => 'decimal:2',
        'duration_minutes' => 'integer',
        'exam_date' => 'datetime',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')->withPivot('marks_assigned');
    }

    public function results()
    {
        return $this->hasMany(ExamResult::class);
    }
}
