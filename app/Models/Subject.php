<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;
#[Fillable(['name', 'institution_id', 'code', 'course_id'])]
class Subject extends Model
{
    use BelongsToInstitution;
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
