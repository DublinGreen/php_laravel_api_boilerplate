<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\OrderStatus;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userObj  = User::find(1);
        $paymentObj  = Payment::find(1);
        $orderStatusObj  = OrderStatus::find(1);

        $data = [
            [
                'uuid' => Uuid::uuid4(),
                'user_id' => 1,
                'payment_id' => 1,
                'order_status_id' => 1,
                'products' => 'Dog 101',
                'products' => '{
                    "product": "string",
                    "quantity": "2"
                }',
                'address' => '{
                    "billing": "string",
                    "shipping": "string"
                }',
                'amount' => 1300.00,
                'delivery_fee' => 100.00,
                'shipped_at' => now(),
                'created_at' => now(),
            ],
            [
                'uuid' => Uuid::uuid4(),
                'user_id' => 2,
                'payment_id' => 2,
                'order_status_id' => 2,
                'products' => 'Dog 101',
                'products' => '{
                    "product": "string",
                    "quantity": "4"
                }',
                'address' => '{
                    "billing": "string",
                    "shipping": "string"
                }',
                'amount' => 1300.00,
                'delivery_fee' => 100.00,
                'shipped_at' => now(),
                'created_at' => now(),
            ],
        ];
        Order::insert($data);
    }
}
