<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\BlogPost;

class BlogPostTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tagCount = Tag::all()->count();

        if (0 === $tagCount) {
        	$this->command->info('No tags found, skipping assigning tags to blog posts');
        	return;
        }

        BlogPost::all()->each(function (BlogPost $post) {
            $take = random_int(1, 4);
            $tags = Tag::inRandomOrder()->take($take)->get()->pluck('id');
            $post->tags()->sync($tags);
        });
    }
}
