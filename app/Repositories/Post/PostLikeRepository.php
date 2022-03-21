<?php

namespace App\Repositories\Post;

use App\Models\PostLike;
use App\Repositories\BaseRepository;

class PostLikeRepository extends BaseRepository
{
    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(PostLike $model)
    {
        parent::__construct($model);
    }

}
