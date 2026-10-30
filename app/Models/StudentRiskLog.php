<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;
#[Fillable(['institution_id', 'student_id', 'previous_level', 'new_level', 'reasons', 'calculated_at'])]
class StudentRiskLog extends Model
{
    use BelongsToInstitution;
    public $timestamps = false;
    protected $casts = [
        'calculated_at' => 'datetime',
        'reasons' => 'array'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
