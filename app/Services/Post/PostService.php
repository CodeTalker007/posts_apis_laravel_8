<?php

namespace App\Services\Post;

use App\Repositories\Post\PostRepository;

class PostService
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }
}
