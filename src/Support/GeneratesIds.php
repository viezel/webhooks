<?php
declare(strict_types=1);

namespace Viezel\Webhooks\Support;

use Illuminate\Support\Str;

trait GeneratesIds
{
    public static function bootGeneratesIds(): void
    {
        static::creating(function (self $model) {
            if (! $model->getKey()) {
                $model->setAttribute($model->getKeyName(), (string) Str::orderedUuid());
            }
        });
    }

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return 'string';
    }

    public function getIdAttribute($value): string
    {
        return (string) $value;
    }
}
