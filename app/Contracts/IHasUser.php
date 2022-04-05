<?php

namespace App\Contracts;

use App\Entities\User;

interface IHasUser
{
    /**
     * Returns entity owner.
     *
     * @return User|null
     */
    public function getUser(): ?User;
}
