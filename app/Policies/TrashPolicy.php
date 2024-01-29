<?php

namespace App\Policies;

use App\Domain\User\Constants\UserRole;
use App\Models\Blog\Trash;
use App\Models\User\User;

class TrashPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Trash $trash): bool
    {
        return $user->role === UserRole::Admin->value;
    }


    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Trash $trash): bool
    {
        return false;
    }

    public function delete(User $user, Trash $trash): bool
    {
        return false;
    }

    public function restore(User $user, Trash $trash): bool
    {
        return $user->role === UserRole::Admin->value;
    }

    public function forceDelete(User $user, Trash $trash): bool
    {
        return $user->role === UserRole::Admin->value;
    }
}
