<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PostMethod
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'author','id');
    }
}
