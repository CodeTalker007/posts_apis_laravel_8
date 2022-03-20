<?php

namespace App\Repositories\Auth;

use App\Events\UserRegistered;
use App\Models\User;
use App\Repositories\BaseRepository;

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
