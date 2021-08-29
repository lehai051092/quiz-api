<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected User $user;

    /**
     * @param User $user
     */
    public function __construct(
        User $user
    ) {
        $this->user = $user;
    }

    /**
     * @param $user
     * @return mixed
     */
    public function createUser($user)
    {
        return $this->user->create($user);
    }
}
