<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConfirmPasswordRequest;
use App\Http\Requests\ForgetPasswordRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForgetPasswordController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService){
        $this->authService = $authService;
    }
    /**
     * @param ForgetPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function forget(ForgetPasswordRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->authService->forget($request->validated());
            return $this->success([], null, trans('messages.forget_password_success'));
        }

        catch (\Exception $e){
            return $this->failure('', $e->getMessage(),Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @param string $token
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function reset(string $token){
        $user = $this->authService->validateTokenAndGetUser($token);
        if (!isset($user)) {
            return $this->failure('', trans('messages.forget_password_invalid_token'), Response::HTTP_BAD_REQUEST);
        }
        //return redirect(Config::get('app.frontend').'/reset-password/'.$token);
        return $this->success([],null,trans('messages.forget_password_link_success'));
    }

    /**
     * @param ConfirmPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function confirm(ConfirmPasswordRequest $request)
    {
        $result = $this->authService->confirm($request->validated());
        if (!isset($result)) {
            return $this->failure('', trans('messages.forget_password_invalid_token_or_email'), Response::HTTP_BAD_REQUEST);
        }
        return $this->success([], null, trans('messages.forget_password_reset_success'));
    }
}
