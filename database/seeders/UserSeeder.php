<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'name' => 'Edo Galih Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => date('Y/m/d h:i:s'),
                'role_id' => 1
            ],
            [
                'id' => 2,
                'name' => 'Edo Galih Kasir',
                'email' => 'kasir@mail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => date('Y/m/d h:i:s'),
                'role_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Edo Galih Staff-Dapur',
                'email' => 'staff@mail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => date('Y/m/d h:i:s'),
                'role_id' => 3
            ], 
            [
                'id' => 4,
                'name' => 'Edo Galih Buyer',
                'email' => 'buyer@mail.com',
                'password' => Hash::make('12345678'),
                'email_verified_at' => date('Y/m/d h:i:s'),
                'role_id' => 4
            ], 
        ];

        User::insert($users);
    }
}