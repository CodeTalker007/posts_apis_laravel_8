<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use App\Http\Traits\ModelMethods\PostLikeMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory, HasUuid, PostLikeMethod;
    protected $table='post_likes';
    protected $fillable=[
        'post_id',
        'user_id',
    ];
}
