<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            [
                'publisher_id' => 1,
                'title' => 'Frontend Developer Job',
                'description' => 'We are looking for an experienced frontend developer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 2,
                'title' => 'Backend Developer Role',
                'description' => 'We are seeking a skilled backend developer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'publisher_id' => 3,
                'title' => 'Full Stack Developer Position',
                'description' => 'Join us as a full stack developer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
