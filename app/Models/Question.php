<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['topic_id', 'institution_id', 'subject_id', 'type', 'question_text', 'options', 'correct_answer', 'marks', 'difficulty', 'board_name', 'board_year','language'])]
class Question extends Model
{
    use BelongsToInstitution;
    protected $casts = [
        'options' => 'array',
        'marks' => 'decimal:2'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
