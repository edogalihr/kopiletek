<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeDetailTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_employee_detail()
    {
        //creating new employee
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Testing Detail',
            'email' => 'testingdet@mail.com',
            'password' => 12345678,
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee/3');

        $response->assertSeeText("Employee ID");
        $response->assertSeeText("User ID");
        $response->assertSeeText("Role");
        $response->assertSeeText("Email");
        $response->assertSeeText("Name");
        $response->assertSeeText("Date of Birth");
        $response->assertSeeText("Address");
        $response->assertSeeText("Phone");
        $response->assertSeeText("Gender");

        $response->assertSee("3");
        $response->assertSee("3");
        $response->assertSee("testingdet@mail.com");
        $response->assertSee("Testing Detail");
        $response->assertSee("2002-11-11");
        $response->assertSee("Bandung");
        $response->assertSee("083114514125");
        $response->assertSee("Male");
        
        $response->assertStatus(200);
    }
}