<?php

namespace App\Repositories\Auth;

use App\Events\UserRegistered;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\PersonalAccessTokenResult;

class AuthRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * Register the new user
     * @param array $userData
     * @return mixed
     */
    public function register(array $userData)
    {
        $user = $this->model->create($userData);
        UserRegistered::dispatch($user);
        return $user;
    }
    /**
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function validateUser(string $email, string $password): bool
    {
        return Auth::attempt([
            'email' => $email,
            'password' => $password,
        ]);
    }
    /**
     * @param User $user
     * @param $rememberMe
     * @return PersonalAccessTokenResult
     */
    public function createUserToken(array $data, $rememberMe): PersonalAccessTokenResult
    {
        $user = User::where('email', $data['email'])->first();
        $tokenResult = $user->createToken(env('APP_PERSONAL_TOKEN'));
        $token = $tokenResult->token;
        if ($rememberMe) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        $token->save();

        Log::info(__METHOD__ . " -- User login success: ", ["email" => $user->email, "token_expires_at" => $token->expires_at]);

        return $tokenResult;
    }
    /**
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        return $request->user()->token()->delete();
    }

    /**
     * Gets User Activation token
     * @param $token
     * @return mixed
     */
    public function getUserFromToken($token)
    {
        return $this->getColumnData('activation_token',$token);
    }
    /**
     * @param User $user
     * @return User
     */
    public function userActivate(User $user): User
    {
        $user->email_verified_at = now();
        $user->activation_token = '';
        $user->save();
        return $user;
    }
}
