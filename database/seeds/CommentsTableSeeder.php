<?php

use Illuminate\Database\Seeder;
use App\BlogPost;
use App\Comment;
use App\User;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$posts = BlogPost::all();

        $users = User::all();

        factory(Comment::class, 150)->make()->each(function ($comment) use ($posts, $users) {
        	$comment->blog_post_id = $posts->random()->id();
            $post->user_id = $users->random()->id;
        	$comment->save();
        });	
    }
}
