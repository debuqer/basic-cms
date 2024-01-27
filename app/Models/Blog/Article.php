<?php

namespace App\Models\Blog;

use App\Framework\Model\Concerns\HasUUIDKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use HasUUIDKey;

    protected $fillable = [
        'id',
        'title',
        'content',
        'status',
        'author_id',
        'created_at',
        'deleted_at',
        'deleted_by',
    ];
}
