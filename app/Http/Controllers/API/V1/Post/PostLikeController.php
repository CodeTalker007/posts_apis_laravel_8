<?php

namespace App\Http\Controllers\API\V1\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Post\PostLikeService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostLikeController extends Controller
{
    /**
     * @var PostLikeService
     */
    protected PostLikeService $postLikeService;

    /**
     * @param PostLikeService $postLikeService
     */
    public function __construct(PostLikeService $postLikeService){
        $this->postLikeService = $postLikeService;
    }
    public function likePost(Post $post): \Illuminate\Http\JsonResponse
    {
        try{
            $this->postLikeService->likePost($post->id);
            return $this->success([], null, trans('messages.post_like_success'));
        }
        catch (\Exception $exception){
            return $this->failure('', trans('messages.post_like_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
