<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\Traits\BelongsToInstitution;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['subject_id', 'institution_id', 'parent_id', 'title'])]
class Topic extends Model
{
    use BelongsToInstitution;
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function parentTopic()
    {
        return $this->belongsTo(Topic::class, 'parent_id');
    }

    public function subTopics()
    {
        return $this->hasMany(Topic::class, 'parent_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
