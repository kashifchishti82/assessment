<?php

namespace App\Services;

use App\Http\Requests\RegisterUser;
use App\Interfaces\IAuthService;
use App\Interfaces\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthService implements IAuthService
{

    public function __construct(protected IUserRepository $userRepository)
    {
        // Nothing so far here
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $user = $this->userRepository->findByEmail($request->email);
        if (!$user) {
            return response()->json(['message' => 'Invalid email'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token], 200);
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);
        $this->userRepository->create($data);
        return response()->json(['message' => 'User registered successfully'], 201);
    }


    public function savePreferences(array $payload)
    {
        $user = auth()->user();
        $user->preferences = $payload;
        $user->save();
        return response()->json(['message' => 'Preferences saved successfully', 'user'=> $user], 201);
    }

    public function getPreferences()
    {
        $user = auth()->user();
        return response()->json(['prefrences' => $user->preferences], 201);
    }
}
