<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;
#[Fillable(['institute_id', 'batch_id', 'schedule_id', 'student_id', 'date', 'status', 'marked_by', 'remarks', 'method'])]
class Attendance extends Model
{
    use BelongsToInstitution;
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function marker()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }
}
