<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the admin user already exists
        $adminUser = User::where('email', 'admin@gmail.com')->first();

        // Create the admin user if it doesn't exist
        if (!$adminUser) {
            User::create([
                'username' => 'administrator',
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123123123'),
            ]);
        }

        // Use factory to create additional users
        $usernames = User::pluck('username')->toArray();

        User::factory()
            ->count(0) // Set count to 0 in the factory method
            ->create()
            ->each(function ($user) use (&$usernames) {
                // Ensure unique usernames
                do {
                    $username = \Faker\Factory::create()->unique()->userName;
                } while (in_array($username, $usernames));

                $user->update(['username' => $username]);
                $usernames[] = $username;
            });
    }
}