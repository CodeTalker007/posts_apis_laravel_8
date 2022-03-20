<?php

namespace App\Http\Traits\ModelMethods;

use App\Models\Post;
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
}
