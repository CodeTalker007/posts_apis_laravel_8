<?php

namespace App\Services\Post;

use App\Repositories\Post\PostLikeRepository;
use Illuminate\Support\Facades\Auth;

class PostLikeService
{
    /**
     * @var PostLikeRepository
     */
    protected PostLikeRepository $postLikeRepository;

    public function __construct(PostLikeRepository $postLikeRepository){
        $this->postLikeRepository = $postLikeRepository;
    }
    public function likePost($postId){
        $postLike = $this->preparePostLikePayload($postId);
       return $this->postLikeRepository->create($postLike);
    }

    /**
     * @param $postId
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unlikePost($postId){
        return $this->postLikeRepository->deletePostLike($postId);
    }
    public function preparePostLikePayload($postId): array
    {
        return [
            'user_id'=>Auth::id(),
            'post_id'=>$postId
        ];
    }
}
