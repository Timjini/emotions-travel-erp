<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DestinationSeeder extends Seeder
{
    public function run()
    {
        $destinations = [
            ['name' => 'Paris', 'country' => 'France', 'description' => 'City of Light and romance.'],
            ['name' => 'Rome', 'country' => 'Italy', 'description' => 'Historic city with ancient ruins.'],
            ['name' => 'New York', 'country' => 'USA', 'description' => 'The city that never sleeps.'],
            ['name' => 'Tokyo', 'country' => 'Japan', 'description' => 'Blend of tradition and technology.'],
            ['name' => 'Sydney', 'country' => 'Australia', 'description' => 'Harbour city with iconic Opera House.'],
        ];

        foreach ($destinations as $dest) {
            DB::table('destinations')->insert([
                'id' => (string) Str::uuid(),
                'name' => $dest['name'],
                'country' => $dest['country'],
                'description' => $dest['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
