<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;

class PostRepository extends BaseRepository
{
    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }
}
