<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@marketlink.com'],
            [
                'name'     => 'Admin',
                'password' => 'Admin@123',
                'role'     => 'admin',
                'phone'    => '03000000000',
                'address'  => 'Karachi',
                'status'   => 'active',
            ]
        );
    }
}