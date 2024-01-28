<?php

use App\Domain\User\Constants\UserRole;


return [
    UserRole::Author->value => [
        'article.create',
        'article.update',
    ],
    UserRole::Admin->value => [
        'article.delete',
        'article.restore',
        'article.publish',
    ],
];
