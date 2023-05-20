<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        for ($i = 0; $i < 15; $i++) {
            DB::table('packages')->insert([
                'uuid' => Str::uuid(),
                'name' => Str::random(10),
                'limit' => random_int(3, 8)
            ]);
        }
    }
}
