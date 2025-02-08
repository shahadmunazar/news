<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

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
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('admin');
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'), 
        ]);
        $user->assignRole('user'); 
        $user2 = User::create([
            'name' => 'Second Regular User',
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user2->assignRole('user');
    
        $admin2 = User::create([
            'name' => 'Second Admin User',
            'email' => 'admin2@example.com',
            'password' => bcrypt('password123'),
        ]);
        $admin2->assignRole('admin');
    }
}
