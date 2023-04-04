<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag :: factory() -> count(5) -> make() -> each(function($tag){
            $user = User :: inRandomOrder() -> first();
            $tag -> user()-> associate($user);
            $tag -> save();
        });
    }
}
