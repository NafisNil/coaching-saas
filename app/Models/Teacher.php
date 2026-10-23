<?php

namespace App\Models;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['institution_id', 'user_id', 'designation', 'joining_date', 'employment_type', 'monthly_salary'])]
class Teacher extends Model
{
    use BelongsToInstitution;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
