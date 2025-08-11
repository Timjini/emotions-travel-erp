<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    public function run()
    {
        $programs = [
            ['name' => 'Romantic Getaway', 'description' => '3 nights in a luxury hotel with guided city tours.', 'base_price' => 1500.00],
            ['name' => 'Adventure Package', 'description' => 'Includes hiking, rafting, and camping.', 'base_price' => 900.00],
            ['name' => 'Cultural Experience', 'description' => 'Museum tours and local cuisine tasting.', 'base_price' => 1200.00],
            ['name' => 'Family Fun Trip', 'description' => 'Amusement parks and family-friendly attractions.', 'base_price' => 800.00],
            ['name' => 'Luxury Cruise', 'description' => '7-day cruise with all-inclusive amenities.', 'base_price' => 3000.00],
        ];

        foreach ($programs as $prog) {
            DB::table('programs')->insert([
                'id' => (string) Str::uuid(),
                'name' => $prog['name'],
                'description' => $prog['description'],
                'base_price' => $prog['base_price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
