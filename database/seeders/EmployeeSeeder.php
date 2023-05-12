<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = [
            [
            'user_id' => 2,	
            'date_of_birth' => '2002-07-07',
            'address' => 'Jalan Kayu Putih No 33',
            'phone' => '+62879087645',
            'sex' => 'F',
            ],
        ];

        Employee::insert($employees);
    }
}