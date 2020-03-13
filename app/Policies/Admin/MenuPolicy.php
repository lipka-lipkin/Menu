<?php

namespace App\Policies\Admin;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any menus.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->getPermission('index_menu');
    }

    /**
     * Determine whether the user can view the menu.
     *
     * @param User $user
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->getPermission('show_menu');
    }

    /**
     * Determine whether the user can create menus.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->getPermission('store_menu');
    }

    /**
     * Determine whether the user can update the menu.
     *
     * @param User $user
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->getPermission('update_menu');
    }

    /**
     * Determine whether the user can delete the menu.
     *
     * @param User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->getPermission('delete_menu');
    }
}
