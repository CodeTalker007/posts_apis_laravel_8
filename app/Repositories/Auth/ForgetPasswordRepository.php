<?php

namespace App\Repositories\Auth;

use App\Models\PasswordReset;
use App\Repositories\BaseRepository;

class ForgetPasswordRepository extends BaseRepository
{
    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(PasswordReset $model)
    {
        parent::__construct($model);
    }
    /**
     * @param string $token
     * @return null
     */
    public function validateTokenAndGetUser(string $token)
    {
        $passwordReset = $this->model->with('user')->where(['token' => $token])->first();
        if (!isset($passwordReset) || ($passwordReset->created_at->diffInMinutes(\Carbon\Carbon::now()) > 30)) {
            return null;
        }
        return $passwordReset->user;
    }

    /**
     * @param string $token
     * @return mixed
     */
    public function deletePasswordResetToken(string $token){
        return $this->model->where('token',$token)->delete();
    }

    /**
     * @param string $email
     * @return bool
     */
    public function removeAllPasswordResetToken(string $email):bool
    {
        return $this->model->where('email', $email)->delete();
    }
}
