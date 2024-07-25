<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Dogs',
                'slug' => 'pet-dogs',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Cats',
                'slug' => 'pet-cats',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Fish',
                'slug' => 'pet-fish',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Reptile',
                'slug' => 'pet-reptile',
                'created_at' => now(),
            ],
        ];
        Category::insert($data);
    }
}
