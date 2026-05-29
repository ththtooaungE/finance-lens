<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Anna', 'email' => 'anna@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-01-01 00:00:00'],
            ['name' => 'Daisy', 'email' => 'daisy@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-01-01 00:00:00'],
            ['name' => 'Traxie', 'email' => 'traxie@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-02-01 00:00:00'],
            ['name' => 'Rose', 'email' => 'rose@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-03-01 00:00:00'],
            ['name' => 'Rain', 'email' => 'rain@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-03-01 00:00:00'],
            ['name' => 'Mash', 'email' => 'mash@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-03-01 00:00:00'],
            ['name' => 'Titan', 'email' => 'titan@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-04-01 00:00:00'],
            ['name' => 'Ryan', 'email' => 'ryan@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-04-01 00:00:00'],
            ['name' => 'Lucy', 'email' => 'lucy@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-04-01 00:00:00'],
            ['name' => 'Sophia', 'email' => 'sophia@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-04-01 00:00:00'],
            ['name' => 'Marco', 'email' => 'marco@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-05-01 00:00:00'],
            ['name' => 'Tony', 'email' => 'tony@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-05-01 00:00:00'],
            ['name' => 'George', 'email' => 'george@example.com', 'password_hash' => bcrypt('Password@123'), 'role' => 'user', 'is_active' => true, 'created_at' => '2026-05-01 00:00:00'],
        ];

        \App\Models\User::insert($users);
    }
}
