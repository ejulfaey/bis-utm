<?php

namespace App\Policies;

use App\Models\Parameter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ParameterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return in_array($user->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Parameter $parameter)
    {
        return in_array($user->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Parameter  $parameter
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Parameter $parameter)
    {
        return in_array($user->role_id, [Role::SUPERADMIN, Role::ADMIN]);
    }
}
