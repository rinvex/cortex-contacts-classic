<?php

declare(strict_types=1);

namespace Cortex\Contacts\Policies;

use Rinvex\Fort\Contracts\UserContract;
use Rinvex\Contacts\Contracts\ContactContract;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list contacts.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function list($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create contacts.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Contracts\UserContract $user
     *
     * @return bool
     */
    public function create($ability, UserContract $user)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Contracts\UserContract        $user
     * @param \Rinvex\Contacts\Contracts\ContactContract $resource
     *
     * @return bool
     */
    public function update($ability, UserContract $user, ContactContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update contacts
    }

    /**
     * Determine whether the user can delete the contact.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Contracts\UserContract        $user
     * @param \Rinvex\Contacts\Contracts\ContactContract $resource
     *
     * @return bool
     */
    public function delete($ability, UserContract $user, ContactContract $resource)
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete contacts
    }
}
