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
            $tags = Tag::factory(rand(0, 5))->make(); //crea da 1 a 5 risultati 
            $user->tag()->saveMany($tags);
        });
    }
}

