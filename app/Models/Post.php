<?php

namespace App\Models;

use App\Http\Traits\HasUuid;
use App\Http\Traits\ModelMethods\PostMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUuid, PostMethod;
    protected $table='posts';
    protected $fillable=[
        'image',
        'description',
        'date',
        'author',
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
