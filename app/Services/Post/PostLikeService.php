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
    public function preparePostLikePayload($postId): array
    {
        return [
            'user_id'=>Auth::id(),
            'post_id'=>$postId
        ];
    }
}
