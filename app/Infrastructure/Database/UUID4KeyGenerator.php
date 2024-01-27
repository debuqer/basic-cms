<?php

namespace App\Infrastructure\Database;

use App\Framework\Database\NonIncrementalKey;
use Illuminate\Support\Str;

class UUID4KeyGenerator implements NonIncrementalKey
{

    public function new()
    {
        return Str::uuid();
    }
}
