<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;

#[Fillable(['batch_id', 'institution_id', 'academic_year_id', 'course_id', 'name', 'max_capacity', 'status'])]
class Batch extends Model
{
    use BelongsToInstitution;   
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'batch_student')->withPivot('status', 'joined_at');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
