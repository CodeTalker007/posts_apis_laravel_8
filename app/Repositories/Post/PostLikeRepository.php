<?php

namespace App\Repositories\Post;

use App\Models\PostLike;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class PostLikeRepository extends BaseRepository
{
    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(PostLike $model)
    {
        parent::__construct($model);
    }
    public function deletePostLike($postId){
        return $this->model->where('user_id',Auth::id())->where('post_id',$postId)->delete();
    }

}
