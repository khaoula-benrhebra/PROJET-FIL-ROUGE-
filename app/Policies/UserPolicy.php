<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->canAccess('gerer_utilisateurs');
    }

    public function view(User $user, User $model)
    {
        return $user->id === $model->id || $user->canAccess('gerer_utilisateurs');
    }

    public function create(User $user)
    {
        return $user->canAccess('gerer_utilisateurs');
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id || $user->canAccess('gerer_utilisateurs');
    }

    public function delete(User $user, User $model)
    {
        return $user->canAccess('gerer_utilisateurs');
    }

    public function approveManager(User $user)
    {
        return $user->hasRole('Administrateur');
    }
}