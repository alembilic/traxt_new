<?php

namespace App\Policies;

use App\Contracts\IHasUser;
use App\Entities\User;

class BasePolicy
{
    public const SHOW = 'show';
    public const UPDATE = 'update';
    public const DESTROY = 'destroy';

    /**
     * Shows whether user could perform this action
     *
     * @param User $user User to check
     * @param IHasUser $entityWithUser Entity with user
     *
     * @return boolean
     */
    protected function belongsToUser(User $user, IHasUser $entityWithUser): bool
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return $entityWithUser->getUser()?->getId() === $user->getId();
    }

    /**
     * Shows whether user could perform this action
     *
     * @param User $user User to check
     * @param IHasUser $entityWithUser Entity with user
     *
     * @return boolean
     */
    public function show(User $user, IHasUser $entityWithUser): bool
    {
        return $this->belongsToUser($user, $entityWithUser);
    }

    /**
     * Shows whether user could perform this action
     *
     * @param User $user User to check
     * @param IHasUser $entityWithUser Entity with user
     *
     * @return boolean
     */
    public function update(User $user, IHasUser $entityWithUser): bool
    {
        return $this->belongsToUser($user, $entityWithUser);
    }

    /**
     * Shows whether user could perform this action
     *
     * @param User $user User to check
     * @param IHasUser $entityWithUser Entity with user
     *
     * @return boolean
     */
    public function destroy(User $user, IHasUser $entityWithUser): bool
    {
        return $this->belongsToUser($user, $entityWithUser);
    }
}
