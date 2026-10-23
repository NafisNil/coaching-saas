<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'institution_id', 'code', 'description'])]
class Course extends Model
{
    use BelongsToInstitution;
    public function batches()
    {
        return $this->hasMany(Batch::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
