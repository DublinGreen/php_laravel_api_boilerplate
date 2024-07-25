<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Brand 1',
                'slug' => 'brand-1',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Brand 2',
                'slug' => 'brand-2',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Brand 3',
                'slug' => 'brand-3',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Brand 4',
                'slug' => 'brand-4',
                'created_at' => now(),
            ],
        ];
        Brand::insert($data);
    }
}
