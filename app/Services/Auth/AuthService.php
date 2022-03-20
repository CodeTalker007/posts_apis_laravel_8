<?php

namespace App\Services\Auth;

use App\Repositories\Auth\AuthRepository;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;
use InvalidArgumentException;
class AuthService
{
    /**
     * @var UserTransformer
     */
    private AuthRepository $repository;

    /**
     * @var AuthRepository
     */

    public function __construct(
        AuthRepository $repository
    ) {
        $this->repository = $repository;
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

}
