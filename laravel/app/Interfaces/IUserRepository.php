<?php

namespace App\Interfaces;

interface IUserRepository
{
    public function create(array $payload);
    public function findByEmail(string $email);

    public function savePreferences(array $payload);
}
