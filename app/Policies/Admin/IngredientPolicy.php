<?php

namespace App\Policies\Admin;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IngredientPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any ingredients.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->getPermission('index_ingredient')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can create ingredients.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->getPermission('store_ingredient')
            ? Response::allow()
            : Response::deny('Forbidden');

    }

    /**
     * Determine whether the user can view the ingredient.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->getPermission('show_ingredient')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can update the ingredient.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->getPermission('update_ingredient')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can delete the ingredient.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->getPermission('delete_ingredient')
            ? Response::allow()
            : Response::deny('Forbidden');
    }
}
