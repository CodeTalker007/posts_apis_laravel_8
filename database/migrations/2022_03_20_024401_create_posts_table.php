<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('posts')){
            Schema::create('posts', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('image');
                $table->date('date');
                $table->longText('description');
                $table->uuid('author');
                $table->softDeletes();
                $table->timestamps();
            });
            Schema::table('posts',function (Blueprint $table){
                $table->foreign('author')->references('id')->on('users')->cascadeOnUpdate();
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
        if(Schema::hasTable('posts')){
            Schema::dropIfExists('posts');
        }
    }
}
