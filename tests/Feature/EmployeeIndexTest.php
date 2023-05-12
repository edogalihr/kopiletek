<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeIndexTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_access_employee_table()
    {
        //create new user for admin login
        User::create([
            'name' => 'Atmayanti 2',
            'email' => 'maya@mail.com',
            'password' => Hash::make(12345678),
            'role_id' => '1',
        ]);

        //search user with id 1 and login
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee');

        //check if the user can access the page
        $response->assertStatus(200);
    }
    
    public function test_employee_table_has_no_data()
    {
        //search user with id 1 and login
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee');
        
        //see if the text was appear
        $response->assertSeeText("Employee Id");
        $response->assertSeeText("User Id");
        $response->assertSeeText("Role");
        $response->assertSeeText("Name");
        $response->assertSeeText("Action");
        $response->assertSeeText("Tidak ada data");

        //check if the user can access the page
        $response->assertStatus(200);
    }
    
    public function test_employee_table_has_one_data()
    {
        //create 1 employee
        Employee::create([
            'user_id'=> '1',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'F',
        ]);
        
        //search user with id 1 and login
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee');
        
        //see if the text was appear
        $response->assertSeeText("Employee Id");
        $response->assertSeeText("User Id");
        $response->assertSeeText("Role");
        $response->assertSeeText("Name");
        $response->assertSeeText("Action");

        $response->assertSeeText("Atmayanti 2");
        $response->assertSeeText("Detail");
        $response->assertSeeText("Edit");
        $response->assertSeeText("Delete");
        
        //check if the user can access the page
        $response->assertStatus(200);
    }
}