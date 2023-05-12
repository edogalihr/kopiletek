<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeCreateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_create_employee()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee/create');

        $response->assertSeeText('Employee');
        $response->assertSeeText('Add Employee');
        $response->assertSeeText('Name');
        $response->assertSeeText('Email');
        $response->assertSeeText('Password');
        $response->assertSeeText('Role');
        $response->assertSeeText('Date of Birth');
        $response->assertSeeText('Address');
        $response->assertSeeText('Phone');
        $response->assertSeeText('Gender');
        $response->assertSeeText('Submit');
        
        $response->assertStatus(200);
    }
    
    public function test_all_input_is_filled()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Testing',
            'email' => 'testing@mail.com',
            'password' => 12345678,
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertValid(['Employee Added Successfully']);
        $response->assertStatus(302);
    }
    
    public function test_all_input_is_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> '',
            'email' => '',
            'password' => '',
            'role_id' => '',
            'date_of_birth' => '',
            'address' => '',
            'phone' => '',
            'sex' => '',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'password' => 'The password field is required.',
            'date_of_birth' => 'The date of birth field is required.',
            'address' => 'The address field is required.',
            'phone' => 'The phone field is required.',
        ]);
        
        $response->assertStatus(302);
    }
    
    public function test_name_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> '',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_name_more_than_50_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name must not be greater than 50 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_name_less_than_3_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'a',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name must be at least 3 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_email_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti 3',
            'email' => '',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'email' => 'The email field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_password_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti 3',
            'email' => 'testing@mail.com',
            'password' => '',
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'password' => 'The password field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_password_more_than_255_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'password' => 'The password must not be greater than 255 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_password_less_than_8_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 123456,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'password' => 'The password must be at least 8 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_date_of_birth_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti 3',
            'email' => 'testing@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '',
            'address' => 'Tulungagung',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'date_of_birth' => 'The date of birth field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti 3',
            'email' => 'testing@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2022-06-06',
            'address' => 'Tulungagung',
            'phone' => '',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_more_than_15_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'Tulungagung',
            'phone' => '0831145141256666666666666',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone must not be greater than 15 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_less_than_10_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 123456,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'T',
            'phone' => '0831',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone must be at least 10 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti 3',
            'email' => 'testing@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2022-06-06',
            'address' => '',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_more_than_255_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address must not be greater than 255 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_less_than_3_character()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 123456,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'T',
            'phone' => '083114514125',
            'sex' => 'Female',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address must be at least 3 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_sex_required()
    {
        $response = $this->withoutMiddleware()->post('/admin/employee', [
            'name'=> 'Atmayanti',
            'email' => 'test@mail.com',
            'password' => 12345678,
            'role_id' => '3',
            'date_of_birth' => '2002-06-06',
            'address' => 'T',
            'phone' => '083114514125',
            'sex' => '',
        ]);
        
        $response->assertInvalid([
            'sex' => 'The sex field is required.'
        ]);
        $response->assertStatus(302);
    }
    
}