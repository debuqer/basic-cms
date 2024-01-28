<?php

namespace App\Infrastructure\Authorization;

use App\Framework\Authorization\AuthorizationInterface;
use App\Models\User\User;

class AuthorizationService implements AuthorizationInterface
{
    public function __construct(protected array $rolePermissions)
    {

    }


    public function can(User $user, string $permission): bool
    {
        return isset($this->rolePermissions[$user->role]) && in_array($permission, $this->rolePermissions[$user->role]);
    }
}
