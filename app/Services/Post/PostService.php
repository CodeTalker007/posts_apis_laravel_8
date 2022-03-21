<?php

namespace App\Services\Post;

use App\Events\PostCreated;
use App\Repositories\Post\PostRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PostService
{
    /**
     * @var PostRepository
     */
    protected PostRepository $postRepository;

    public function __construct(PostRepository $postRepository){
        $this->postRepository = $postRepository;
    }

    /**
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data): \Illuminate\Database\Eloquent\Model
    {
       $fileName = $this->postRepository->uploadImageOnDisk($data['image']);
       $data = $this->preparePostPayload($data,$fileName);
         $post = $this->postRepository->create($data);
         PostCreated::dispatch($post);
         return $post;
    }

    /**
     * @param array $data
     * @param string $fileName
     * @return array
     */
    public function preparePostPayload(array $data, string $fileName): array
    {
        return [
            'image'=> $fileName,
            'description'=> $data['description'],
            'author'=>Auth::user()->id,
            'date'=>$data['date']
        ];
    }
    public function index(){
        return $posts = $this->postRepository->getAll(['postLikes.user'],true);
       // return $this->paginate($posts);

    }

    /**
     * @param array $data
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update(array $data,$id)
    {
        $fileName = $this->postRepository->uploadImageOnDisk($data['image']);
        $data = $this->preparePostPayload($data,$fileName);
        $post = $this->postRepository->update($id,$data);
        return $post;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id){
       return $this->postRepository->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id){
        return $this->postRepository->findOrFail($id);
    }

}
