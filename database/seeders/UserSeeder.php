<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Alice',
                'last_name' => 'Smith',
                'phone_number' => '1234567890',
                'email' => 'alice.smith@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Bob',
                'last_name' => 'Johnson',
                'phone_number' => '9876543210',
                'email' => 'bob.johnson@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Charlie',
                'last_name' => 'Williams',
                'phone_number' => '5551234567',
                'email' => 'charlie.williams@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Brown',
                'phone_number' => '1112223333',
                'email' => 'david.brown@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Davis',
                'phone_number' => '9998887777',
                'email' => 'emily.davis@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Frank',
                'last_name' => 'Miller',
                'phone_number' => '4445556666',
                'email' => 'frank.miller@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Grace',
                'last_name' => 'Wilson',
                'phone_number' => '7778889990',
                'email' => 'grace.wilson@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Henry',
                'last_name' => 'Moore',
                'phone_number' => '2223334444',
                'email' => 'henry.moore@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Isabella',
                'last_name' => 'Taylor',
                'phone_number' => '8889990000',
                'email' => 'isabella.taylor@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
            [
                'first_name' => 'Jack',
                'last_name' => 'Anderson',
                'phone_number' => '3334445555',
                'email' => 'jack.anderson@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
                'is_verified' => 1,
                'profile_image' => null,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
