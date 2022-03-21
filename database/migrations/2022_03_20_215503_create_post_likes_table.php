<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('post_likes')){
            Schema::create('post_likes', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('user_id');
                $table->uuid('post_id');
                $table->timestamps();
            });
            Schema::table('post_likes',function (Blueprint $table){
                $table->foreign('post_id')->references('id')->on('posts')->cascadeOnUpdate();
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_likes');
    }
}
