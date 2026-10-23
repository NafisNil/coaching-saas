<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;

#[Fillable(['institution_id', 'subject_id', 'branch_id', 'batch_id', 'teacher_id', 'room_number', 'end_time', 'start_time', 'day_of_week'])]
class Schedule extends Model
{
    use BelongsToInstitution;

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
