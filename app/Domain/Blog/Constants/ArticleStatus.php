<?php

namespace App\Domain\Blog\Constants;

enum ArticleStatus: int
{
    case Draft = 1;
    case Published = 2;
}
