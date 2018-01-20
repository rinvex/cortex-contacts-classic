<?php

declare(strict_types=1);

namespace Cortex\Contacts\Policies;

use Rinvex\Fort\Models\User;
use Rinvex\Contacts\Models\Contact;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can list contacts.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function list($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can create contacts.
     *
     * @param string                              $ability
     * @param \Rinvex\Fort\Models\User $user
     *
     * @return bool
     */
    public function create($ability, User $user): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Models\User        $user
     * @param \Rinvex\Contacts\Models\Contact $resource
     *
     * @return bool
     */
    public function update($ability, User $user, Contact $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can update contacts
    }

    /**
     * Determine whether the user can delete the contact.
     *
     * @param string                                     $ability
     * @param \Rinvex\Fort\Models\User        $user
     * @param \Rinvex\Contacts\Models\Contact $resource
     *
     * @return bool
     */
    public function delete($ability, User $user, Contact $resource): bool
    {
        return $user->allAbilities->pluck('slug')->contains($ability);   // User can delete contacts
    }
}
