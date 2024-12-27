<?php

namespace App\Repositories;

use App\Interfaces\IUserRepository;
use App\Models\User;

class UserRepository implements IUserRepository
{

    public function create(array $payload)
    {
        return (new User())->fill($payload)->save();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function savePreferences(array $payload)
    {
        // TODO: Implement savePreferences() method.
    }
}
