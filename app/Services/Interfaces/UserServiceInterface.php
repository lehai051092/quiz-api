<?php

namespace App\Services\Interfaces;

interface UserServiceInterface
{
    public function handleCreateUser($request);

    public function handleLogin($request);
}
