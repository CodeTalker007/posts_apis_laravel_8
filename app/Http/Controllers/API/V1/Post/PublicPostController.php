<?php

namespace App\Http\Controllers\API\V1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Transformers\Post\PostTransformer;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicPostController extends Controller
{
    /**
     * @var PostService
     */
    protected PostService $postService;

    /**
     * @param PostService $postService
     */
    public function __construct(PostService $postService){
        $this->postService = $postService;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): \Illuminate\Http\JsonResponse
    {
        try{
            $posts =$this->postService->index();

            return $this->success($posts, new PostTransformer(), trans('messages.post_get_all_success'));
        }
        catch (\Exception $exception){
            return $this->failure('', trans('messages.post_get_all_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
