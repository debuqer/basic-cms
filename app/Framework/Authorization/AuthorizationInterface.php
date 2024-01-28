<?php

namespace App\Framework\Authorization;

use App\Models\User\User;

interface AuthorizationInterface
{
    public function can(User $user, string $permission): bool;
}
