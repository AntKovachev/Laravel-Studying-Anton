<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 100 users
        $users = User::factory()->count(100)->create();

        // Create posts for each user
        $users->each(function ($user) {
            Post::factory()->count(10)->create(['user_id' => $user->id]);
        });
    }
}
