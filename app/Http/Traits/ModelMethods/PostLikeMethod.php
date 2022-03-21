<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait PostLikeMethod
{
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function post():BelongsTo
    {
        return $this->belongsTo(Post::class,'post_id','id');
    }
}
