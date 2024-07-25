<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OrderStatus;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Order for pet dog 101',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Order for cat dog 101',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Order for pet fish 101',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'title' => 'Order for pet snake 101',
                'created_at' => now(),
            ],
        ];
        OrderStatus::insert($data);
    }
}
