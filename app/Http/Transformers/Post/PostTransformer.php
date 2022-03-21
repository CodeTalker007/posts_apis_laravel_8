<?php

namespace App\Http\Transformers\Post;

use App\Http\Transformers\BaseTransformer;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostTransformer extends BaseTransformer
{
    public function transform(Post $post)
    {
        $author = $post->user;
        $author = collect($author->toArray())->except(['id', 'created_at', 'updated_at'])->map(function ($item) {
            return $item ?? "";
        });
        $postLikes = $post->postLikes;
        if(count($postLikes)>0){
            $postLikes = $postLikes->user->map(function ($user) {
                return collect($user->toArray())->except(['id', 'created_at', 'updated_at'])->map(function ($item) {
                    return $item ?? "";
                });
            });
        }
        return [
            'id' => $post->id,
            'name' => Storage::disk(config('filesystems.default'))->url($post->image),
            'description' => $post->description,
            'author'=>$author,
            'post_likes' => $postLikes,
        ];
    }
}
