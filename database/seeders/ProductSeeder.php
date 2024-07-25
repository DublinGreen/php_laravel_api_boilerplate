<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandObj  = Brand::find(1);
        $brand2Obj  = Brand::find(2);

        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'category_id' => 1,
                'title' => 'pet dog 101',
                'price' => 1300.00,
                'description' => 'Order for pet dog 101',
                'metadata' => "{
                    'brand': 'string',
                    'image': 'string'
                }",
                'metadata' => '{
                    "brand": "string",
                    "image": "string"
                }',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'category_id' => 2,
                'title' => 'pet cat 101',
                'price' => 1150.00,
                'description' => 'Order for pet cat 101',
                'metadata' => "{
                    'brand': 'string',
                    'image': 'string'
                }",
                'metadata' => '{
                    "brand": "string",
                    "image": "string"
                }',
                'created_at' => now(),
            ],
        ];
        Product::insert($data);
    }
}
