<?php

namespace App\Models;

use App\Http\Traits\ModelMethods\PasswordResetMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    use HasFactory, PasswordResetMethod;
    protected $table = 'password_resets';
    protected $fillable = [
        'email',
        'token'
    ];
    protected $guarded=[
        'updated_at'
    ];
}
