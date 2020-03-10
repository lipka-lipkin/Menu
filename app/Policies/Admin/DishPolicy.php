<?php

namespace App\Policies\Admin;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DishPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any dishes.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->getPermission('index_dish')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can view the dish.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->getPermission('show_dish')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can create dishes.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->getPermission('store_dish')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can update the dish.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->getPermission('update_dish')
            ? Response::allow()
            : Response::deny('Forbidden');
    }

    /**
     * Determine whether the user can delete the dish.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->getPermission('delete_dish')
            ? Response::allow()
            : Response::deny('Forbidden');
    }
}
