<?php

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait GeneratesUuid
{
    protected static function bootGeneratesUuid()
    {
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid();
            }
        });
    }
}
