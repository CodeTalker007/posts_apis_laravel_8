<?php

namespace App\Repositories\Post;

use App\Models\Post;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostRepository extends BaseRepository
{
    protected \Illuminate\Database\Eloquent\Model $model;

    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    /**
     * @param $file
     * @return string
     */
    public function uploadImageOnDisk($file): string
    {
        $disk = config('filesystems.default');
        $destinationPath = "user-posts";
        $fileName = md5($file->getClientOriginalName() . time()). $file->clientExtension();
//        if(Storage::disk($disk)->exists($destinationPath.'/'.$fileName)){
//            Storage::disk($disk)->delete($destinationPath.'/'.$fileName);
//        }
        Storage::disk($disk)->putFileAs($destinationPath,$file,$fileName);
        return $destinationPath.'/'.$fileName;
    }
}
