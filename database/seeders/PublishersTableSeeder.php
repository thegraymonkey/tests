<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublishersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('publishers')->insert([
            [
                'email' => 'publisher1@example.com',
                'approved' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'publisher2@example.com',
                'approved' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'email' => 'publisher3@example.com',
                'approved' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
