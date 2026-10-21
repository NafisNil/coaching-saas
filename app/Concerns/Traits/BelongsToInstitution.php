<?php

namespace App\Concerns\Traits;

use Illuminate\Database\Eloquent\Builder;

trait BelongsToInstitution
{
    //
    protected static function bootBelongsToInstitution()
    {
        static::addGlobalScope('institution', function (Builder $builder) {
            if (auth()->check() && auth()->user()->institution_id) {
                $builder->where('institution_id', auth()->user()->institution_id);
            }
        });

        static::creating(function ($model) {
            if (auth()->check() && empty($model->institution_id)) {
                $model->institution_id = auth()->user()->institution_id;
            }
        });
    }
}
