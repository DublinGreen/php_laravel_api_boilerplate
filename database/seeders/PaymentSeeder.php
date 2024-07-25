<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'type' => \App\Enums\PaymentType::CREDIT_CARD,
                'details' => '{
                    "holder_name": "string",
                    "number": "string",
                    "ccv": "312",
                    "expire_date": "string"
                }',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'type' => \App\Enums\PaymentType::CASH_ON_DELIVERY,
                'details' => '
                    {
                        "first_name": "string",
                        "last_name": "string",
                        "address": "string"
                    }
                ',
                'created_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'type' => \App\Enums\PaymentType::BANK_TRANSFER,
                'details' => '
                    {
                        "swift": "string",
                        "iban": "string",
                        "name": "string"
                    }
                ',
                'created_at' => now(),
            ],
        ];
        Payment::insert($data);
    }
}
