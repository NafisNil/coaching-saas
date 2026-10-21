<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'phone', 'code', 'address', 'institution_id', 'is_main'])]
class Branch extends Model
{
    //
}
