<?php

namespace App\Policies;

use App\User;
use App\Connection;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConnectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the connection list.
     *
     * @param  \App\User  $user
     * @param  \App\Connection  $connection
     * @return mixed
     */
    public function index(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the connection.
     *
     * @param  \App\User  $user
     * @param  \App\Connection  $connection
     * @return mixed
     */
    public function view(User $user, Connection $connection)
    {
        //
    }

    /**
     * Determine whether the user can create connections.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the connection.
     *
     * @param  \App\User  $user
     * @param  \App\Connection  $connection
     * @return mixed
     */
    public function update(User $user, Connection $connection)
    {
        //
    }

    /**
     * Determine whether the user can delete the connection.
     *
     * @param  \App\User  $user
     * @param  \App\Connection  $connection
     * @return mixed
     */
    public function delete(User $user, Connection $connection)
    {
        //
    }
}
