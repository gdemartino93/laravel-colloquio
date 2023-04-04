<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tag;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(1000)->create()->each(function ($user) {
            $tags = Tag::factory(rand(0, 5))->make(); //associa da 0 a 5 tag per user 
            $user->tag()->saveMany($tags);
        });
    }
}

