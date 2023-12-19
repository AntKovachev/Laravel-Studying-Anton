<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all posts
        $posts = Post::all();

        // Loop through each post and create a comment
        $posts->each(function ($post) {
            Comment::factory()->create([
                'post_id' => $post->id,
            ]);
        });
    }
}
