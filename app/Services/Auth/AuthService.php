<?php

namespace App\Services\Auth;

use App\Events\PasswordResetRequest;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Auth\ForgetPasswordRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
use InvalidArgumentException;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthService
{
    /**
     * @var AuthRepository
     */
    private AuthRepository $repository;
    /**
     * @var ForgetPasswordRepository
     */
    private ForgetPasswordRepository $forgetPasswordRepository;

    /**
     * @param AuthRepository $repository
     * @param ForgetPasswordRepository $forgetPasswordRepository
     */

    public function __construct(
        AuthRepository $repository,
        ForgetPasswordRepository $forgetPasswordRepository
    ) {
        $this->repository = $repository;
        $this->forgetPasswordRepository = $forgetPasswordRepository;
    }
    /**
     * @param array $data
     */
    public function register(array $data): void
    {
        Log::info(__METHOD__ . " -- New user request info: ", array_except($data, ["password"]));

        $userData = [
            'password'   => bcrypt($data['password']),
            'name'       => $data['name'],
            'email'      => $data['email'],
            'username'     => $data['username'],
            'activation_token' => Str::random(5),
        ];

        DB::beginTransaction();
        try {
            $user = $this->repository->register($userData);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw new InvalidArgumentException('Unable to create user');
        }

        DB::commit();
    }
    /**
     * @param array $data
     * @return PersonalAccessTokenResult|null
     * @throws ErrorException
     */
    public function login(array $data): ?PersonalAccessTokenResult
    {
        Log::info(__METHOD__ . " -- Consumer login attempt: ", ["email" => $data["email"]]);

        if (!$this->repository->validateUser($data['email'], $data['password'])) {
            Log::error(__METHOD__ . " -- User entered wrong email or password. ", ["email" => $data["email"]]);
            return null;
        }

        return $this->repository->createUserToken($data, $data['remember_me'] ?? null);
    }
    /**
     * @param Request $request
     */
    public function logout(Request $request): void
    {
        $this->repository->logout($request);
        Log::info(__METHOD__ . " -- user: " . auth()->user()->email . " -- User logout success");
    }

    /**
     * @param array $data
     * @return void
     */
    public function forget(array $data)
    {
        $user = $this->repository->getColumnData('email',$data['email']);
        if(!$user){
            throw new NotFoundHttpException(trans('exception.user_not_found'));
        }
        $result = $this->repository->forget($data);
        $data = [
            'user' => $user,
            'token' => $result['token'],
        ];

        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User forget password request");

        PasswordResetRequest::dispatch($data['user'],$data['token']);
    }

    /**
     * @param $token
     * @return User|null
     */
    public function userActivate($token): ?User
    {
        $user = $this->repository->getUserFromToken($token);
        if (!$user) {
            return null;
        }
        if(!is_null($user->email_verified_at)){
            return null;
        }
        $user = $this->repository->userActivate($user);
        Log::info(__METHOD__ . " -- user: " . $user->email . " -- User email verification success");
        return $user;
    }

    /**
     * check reset password link token and validate
     * @param string $token
     * @return mixed
     */
    public function validateTokenAndGetUser(string $token)
    {
        return $this->forgetPasswordRepository->validateTokenAndGetUser($token);
    }


}
