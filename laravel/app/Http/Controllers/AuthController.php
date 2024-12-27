<?php

namespace App\Http\Controllers;

use App\services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(Request $request, AuthService $authService)
    {
        try {
            return $authService->register($request);
        } catch (\Exception $e) {
            logger($e->getMessage(), ['stack' => $e->getTrace()]);
            return response()->json(['message' => 'Something went wrong, Please try again later'], 400);
        }
    }

    public function login(Request $request, AuthService $authService)
    {
        try {
            return $authService->login($request);
        } catch (\Exception $e) {
            logger($e->getMessage(), ['stack' => $e->getTrace()]);
            return response()->json(['message' => 'Something went wrong, Please try again later'], 400);
        }
    }

    public function getPreferences(AuthService $authService)
    {
        return $authService->getPreferences();
    }
    public function savePreferences(Request $request, AuthService $authService)
    {
        return $authService->savePreferences($request->all());
    }
}
