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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->default(1);
            $table->string('imagen')->default('sin imagen');
            $table->text('titulo');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_post');
            $table->unsignedBigInteger('id_user');
            $table->timestamps();

            $table->foreign('id_post')->references('id')->on('posts');
            $table->foreign('id_user')->references('id')->on('user');
        });

        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_follower');
            $table->unsignedBigInteger('id_followed');
            $table->timestamps();

            $table->foreign('id_follower')->references('id')->on('user');
            $table->foreign('id_followed')->references('id')->on('user');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
