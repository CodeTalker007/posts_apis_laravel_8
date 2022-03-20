<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Auth\AuthService;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    private AuthService $service;

    public function __construct(
        AuthService $service
    ) {
        $this->service = $service;
    }

    /**
     * Register the new user
     * @param SignUpRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ErrorException
     */
    public function register(SignUpRequest $request): \Illuminate\Http\JsonResponse
    {
        try{
            $this->service->register($request->validated());
            return $this->success([], null, trans('messages.user_create_success'));
        }
        catch (\Exception $exception){
            throw new ErrorException($exception->getMessage(), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    /**
     * Verify user url
     * @param $token
     * @return RedirectResponse
     */
    public function userActivate($token): JsonResponse
    {
        $verified = $this->service->userActivate($token);
        if (!$verified) {
            return $this->failure('', trans('messages.user_email_verification_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return $this->success([], null, trans('messages.user_email_verification_success'));
    }
}
