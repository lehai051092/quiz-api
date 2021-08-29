<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @var UserServiceInterface
     */
    protected UserServiceInterface $userService;

    /**
     * @param UserServiceInterface $userService
     */
    public function __construct(
        UserServiceInterface $userService
    ) {
        $this->userService = $userService;
    }

    /**
     * Create user
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->handleCreateUser($request);
        return response()->json([
            'code' => 201,
            'user' => $user,
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->userService->handleLogin($request);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
