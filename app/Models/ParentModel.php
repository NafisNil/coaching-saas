<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use App\Concerns\Traits\BelongsToInstitution;

#[Fillable(['institution_id', 'user_id', 'occupation'])]
class ParentModel extends Model
{
    use BelongsToInstitution;
    protected $table = 'parents';
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'parent_student', 'parent_id', 'student_id')
                    ->withPivot('relationship_type', 'is_primary_contact');
    }
}
