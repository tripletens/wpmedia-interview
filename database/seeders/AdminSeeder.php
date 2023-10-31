<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin account

        $admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make("4liberty")
        ]);

        $admin->assignRole("admin");
    }
}
