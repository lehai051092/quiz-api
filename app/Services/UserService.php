<?php

namespace App\Services;

use App\Helper\User\RegisterOption;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;

    /**
     * @var RegisterOption
     */
    protected RegisterOption $registerOption;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param RegisterOption $registerOption
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        RegisterOption          $registerOption
    )
    {
        $this->userRepository = $userRepository;
        $this->registerOption = $registerOption;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function handleCreateUser($request)
    {
        $user = $this->registerOption->optionArray($request);
        return $this->userRepository->createUser($user);
    }

    /**
     * @param $request
     * @return JsonResponse
     */
    public function handleLogin($request): JsonResponse
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);

        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
}
