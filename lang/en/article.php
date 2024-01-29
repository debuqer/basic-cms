<?php

use App\Domain\Blog\Constants\ArticleStatus;

return [
    'attributes' => [
        'title' => 'Title',
        'content' => 'Content',
        'summarize' => 'Summarize',
        'status' => 'Status',
        'author_name' => 'Author\'s name',
        'published_at' => 'Publication date',
    ],

    'status' => [
        ArticleStatus::Draft->value => 'Drafted',
        ArticleStatus::Published->value => 'Published',
    ],

    'actions' => [
        'draft' => 'Draft',
        'publish' => 'Publish',
    ],

    'messages' => [
        'drafted' => 'Drafted !',
        'published' => 'Published !',
    ]

];
