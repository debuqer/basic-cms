<?php

namespace App\Framework\Model\Concerns;

use Illuminate\Support\Str;

trait HasUUIDKey
{
    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
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
}
