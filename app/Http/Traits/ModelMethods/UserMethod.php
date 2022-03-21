<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait UserMethod
{
    /**
     * returns user posts
     * @return mixed
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'author','id');
    }
    public function postLikes(): HasMany
    {
        return $this->hasMany(PostLike::class,'user_id','id');
    }
}
