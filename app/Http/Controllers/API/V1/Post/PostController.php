<?php

namespace App\Http\Controllers\API\V1\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Transformers\Post\PostTransformer;
use App\Models\Post;
use App\Services\Post\PostService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
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
     * @param PostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(PostRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $this->postService->create($request->validated());
            return $this->success([], null, trans('messages.post_create_success'));
        }
        catch (\Exception $exception){
            return $this->failure('', trans('messages.post_create_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            dd($exception);
            return $this->failure('', trans('messages.post_get_all_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PostRequest $request, Post $post): \Illuminate\Http\JsonResponse
    {
        try{
           $post = $this->postService->update($request->validated(),$post->id);
            return $this->success([], null, trans('messages.post_update_success'));
        }
        catch (\Exception $exception){
            return $this->failure('', trans('messages.post_update_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Post $post): \Illuminate\Http\JsonResponse
    {
        try{
            $post = $this->postService->delete($post->id);
            return $this->success([], null, trans('messages.post_delete_success'));
        }
        catch (\Exception $exception){
            return $this->failure('', trans('messages.post_delete_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Post $post): \Illuminate\Http\JsonResponse
    {
        try{
            $posts =$this->postService->show($post->id);
            return $this->success($posts, new PostTransformer(), trans('messages.post_get_success'));
        }
        catch (\Exception $exception){
            dd($exception->getMessage());
            return $this->failure('', trans('messages.post_get_failed'),Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
