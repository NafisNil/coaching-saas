<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['institution_id', 'name', 'start_date', 'end_date', 'is_current'])]

class AcademicYear extends Model
{
    //
}
