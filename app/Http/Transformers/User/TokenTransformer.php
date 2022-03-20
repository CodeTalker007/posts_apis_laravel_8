<?php

namespace App\Http\Transformers\User;

use App\Http\Transformers\BaseTransformer;
use Illuminate\Support\Facades\Auth;

class TokenTransformer extends BaseTransformer
{
    public function transform($token)
    {
        return [
            'id' => Auth::user()->id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'username'=>Auth::user()->username,
            'access_token' => $token->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->token->expires_at
        ];
    }
}
