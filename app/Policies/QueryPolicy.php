<?php

namespace App\Policies;

use App\User;
use App\Query;
use Illuminate\Auth\Access\HandlesAuthorization;

class QueryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the query list.
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
     * Determine whether the user can view the query.
     *
     * @param  \App\User  $user
     * @param  \App\Query  $query
     * @return mixed
     */
    public function view(User $user, Query $query)
    {
        //
    }

    /**
     * Determine whether the user can create queries.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the query.
     *
     * @param  \App\User  $user
     * @param  \App\Query  $query
     * @return mixed
     */
    public function update(User $user, Query $query)
    {
        //
    }

    /**
     * Determine whether the user can delete the query.
     *
     * @param  \App\User  $user
     * @param  \App\Query  $query
     * @return mixed
     */
    public function delete(User $user, Query $query)
    {
        //
    }
}
