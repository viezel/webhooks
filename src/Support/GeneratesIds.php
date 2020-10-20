<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Support;

use Illuminate\Support\Str;

trait GeneratesIds
{
    public static function bootGeneratesIds()
    {
        static::creating(function (self $model) {
            if (! $model->getKey()) {
                $model->setAttribute($model->getKeyName(), (string) Str::orderedUuid());
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function getIdAttribute($value)
    {
        return (string) $value;
    }
}
