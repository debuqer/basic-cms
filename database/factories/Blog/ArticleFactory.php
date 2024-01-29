<?php

namespace Database\Factories\Blog;

use App\Domain\Blog\Constants\ArticleStatus;
use App\Framework\Database\NonIncrementalKey;
use App\Models\User\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog\Article>
 */
class ArticleFactory extends Factory
{

    public function definition(): array
    {
        $authors = User::all();

        return [
            'id' => App::make(NonIncrementalKey::class)->new(),
            'title' => $this->faker->words(asText: true),
            'content' => $this->faker->realText,
            'status' => ArticleStatus::Draft->value,
            'author_id' => $authors->first()->id,
            'created_at' => Carbon::now(),
            'deleted_at' => null,
            'deleted_by' => null,
            'published_at' => null,
        ];
    }

    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => Carbon::now(),
        ]);
    }

    public function drafted(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::Draft->value,
        ]);
    }

    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ArticleStatus::Published->value,
            'published_at' => Carbon::now(),
        ]);
    }

}
