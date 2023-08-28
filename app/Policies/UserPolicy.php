<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;


class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): Response
    {
        return $user->hasAnyRole(['Admin', 'Manager'])
        ? Response::allow()
        : Response::deny('You do not have permission to view users.');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): Response
    {
        return $user->hasAnyRole(['Admin', 'Manager'])
        ? Response::allow()
        : Response::deny('You do not have permission to view users.');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): Response
    {
        return $user->hasAnyRole(['Admin', 'Manager'])
        ? Response::allow()
        : Response::deny('You do not have permission to create users.');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): Response
    {
        // Super Admin can edit any user
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        // Manager can edit own and regular user accounts
        if ($user->hasRole('Manager')) {
            return $user->id === $model->id || $model->hasRole('Regular')
                ? Response::allow()
                : Response::deny('You do not have permission to update users.');
        }

        // Regular User can only edit their own profile
        return $user->id === $model->id
            ? Response::allow()
            : Response::deny('You do not have permission to update users.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model)
    {
        // Super Admin can edit any user
        if ($user->hasRole('Admin')) {
            return Response::allow();
        }

        // Manager can edit own and regular user accounts
        if ($user->hasRole('Manager')) {
            return $user->id === $model->id || $model->hasRole('Regular')
                ? Response::allow()
                : Response::deny('You do not have permission to delete users.');
        }
    }
}
