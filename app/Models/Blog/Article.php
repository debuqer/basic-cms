<?php

namespace App\Models\Blog;

use App\Domain\Blog\Constants\ArticleStatus;
use App\Framework\Model\Concerns\HasUUIDKey;
use App\Models\User\User;
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
        'published_at',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function drafted(): bool
    {
        return $this->status === ArticleStatus::Draft->value;
    }

    public function published(): bool
    {
        return $this->status === ArticleStatus::Published->value;
    }
}
