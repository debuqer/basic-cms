<?php

namespace App\Domain\User\Constants;

enum UserRole: int
{
    case None = 0;
    case Author = 1;
    case Admin = 2;
}
