<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'full_name' => 'Admin Middle Last',
            'phone_number' => '082133898765',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
        $admin->assignRole('admin');

        $user = User::create([
            'full_name' => 'User Middle Last',
            'phone_number' => '082133768997',
            'email' => 'user@gmail.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'avatar_url' => 'https://placekitten.com/300/300'
        ]);
        $user->assignRole('user');
    }
}
