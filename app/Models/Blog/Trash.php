<?php

namespace App\Models\Blog;

use App\Framework\Model\Concerns\HasUUIDKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trash extends Article
{
    use HasFactory;
    use HasUUIDKey;
    use SoftDeletes;

    protected $table = 'articles';

    public function newQuery()
    {
        return parent::newQuery()->withTrashed()->whereNotNull('deleted_at');
    }
}
