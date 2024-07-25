<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'uuid' =>  Uuid::uuid4(),
                'first_name' => 'Bernard',
                'last_name' => 'Dublin-Green',
                'is_admin' => \App\Enums\AdminStatus::YES,
                'is_marketing' => \App\Enums\MarketingStatus::YES,
                'email' => 'greendublin007@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make("Steeldubs0077!@#"),
                'avatar' => null,
                'address' => '33a greenville Estate, Badore Ajah',
                'phone_number' => '+2347032090809',
                'rememberToken' => \App\Enums\MarketingStatus::YES,
                'created_at' => now(),
                'last_login_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'first_name' => 'juliet',
                'last_name' => 'wilcox',
                'is_admin' => \App\Enums\AdminStatus::YES,
                'is_marketing' => \App\Enums\MarketingStatus::YES,
                'email' => 'juliet'.'wilcox'.'@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make("Steeldubs0077!@#"),
                'avatar' => null,
                'address' => '16 Cocacola Estate, Badore Ajah',
                'phone_number' => '+2348023633856',
                'rememberToken' => \App\Enums\MarketingStatus::YES,
                'created_at' => now(),
                'last_login_at' => now(),
            ],
            [
                'uuid' =>  Uuid::uuid4(),
                'first_name' => 'admin',
                'last_name' => 'admin',
                'is_admin' => \App\Enums\AdminStatus::YES,
                'is_marketing' => \App\Enums\MarketingStatus::YES,
                'email' => 'admin'.'admin'.'@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make("Steeldubs0077!@#"),
                'avatar' => null,
                'address' => 'South East London',
                'phone_number' => '+442071234567',
                'rememberToken' => \App\Enums\MarketingStatus::YES,
                'created_at' => now(),
                'last_login_at' => now(),
            ],
        ];
        User::insert($data);
    }
}
