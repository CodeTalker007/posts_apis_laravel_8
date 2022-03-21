<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\PostLike;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

trait PostMethod
{
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'author','id');
    }
    public function postLikes():HasMany
    {
        return $this->hasMany(PostLike::class,'post_id','id');
    }
}
