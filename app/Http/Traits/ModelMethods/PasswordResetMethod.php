<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\User;

trait  PasswordResetMethod
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class,'email','email');
    }
}
