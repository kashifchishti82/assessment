<?php

namespace App\Interfaces;


use Illuminate\Http\Request;

interface IAuthService
{
    public function login(Request $request);

    public function logout();

    public function register(Request $request);

    public function savePreferences(array $payload);

    public function getPreferences();
}
