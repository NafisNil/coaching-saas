<?php

namespace App\Models;

use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['institution_id', 'user_id', 'student_code','branch_id' ,'dob', 'gender', 'address', 'risk_level', 'risk_updated_at'])]
class Student extends Model
{
    use BelongsToInstitution;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'parent_student', 'student_id', 'parent_id')
                    ->withPivot('relationship_type', 'is_primary_contact');
    }
}
