<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeUpdateTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_update_employee()
    {
        $user = User::find(1);
        $response = $this->actingAs($user)->withSession(['banned' => false])->get('/admin/employee/2/edit');
        
        $response->assertSeeText('User ID');
        $response->assertSeeText('Name');
        $response->assertSeeText('Email');
        $response->assertSeeText('Role');
        $response->assertSeeText('Date of Birth');
        $response->assertSeeText('Address');
        $response->assertSeeText('Phone');
        $response->assertSeeText('Gender');
        
        $response->assertSee('2');
        $response->assertSee('Testing');
        $response->assertSee('testing@mail.com');
        $response->assertSee('Kasir');
        $response->assertSee('2002-11-11');
        $response->assertSee('Bandung');
        $response->assertSee('083114514125');
        $response->assertSee('M');
        
        $response->assertStatus(200);
    }
    
    public function test_all_input_is_filled()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 33',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'user_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertValid(['Employee Updated Successfully']);
        $response->assertStatus(302);
    }
    
    public function test_all_input_is_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> '',
            'email' => '',
            'role_id' => '',
            'date_of_birth' => '',
            'address' => '',
            'phone' => '',
            'sex' => '',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name field is required.',
            'email' => 'The email field is required.',
            'date_of_birth' => 'The date of birth field is required.',
            'address' => 'The address field is required.',
            'phone' => 'The phone field is required.',
        ]);
        
        $response->assertStatus(302);
    }
    
    public function test_name_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> '',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_name_more_than_50_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'name' => 'The name must not be greater than 50 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_name_less_than_3_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'T',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M', 
        ]);
        
        $response->assertInvalid([
            'name' => 'The name must be at least 3 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_email_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => '',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'email' => 'The email field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_date_of_birth_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'date_of_birth' => 'The date of birth field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_more_than_15_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125666666666666666666666',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone must not be greater than 15 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_phone_less_than_10_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'phone' => 'The phone must be at least 10 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => '',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address field is required.'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_more_than_255_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandungggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address must not be greater than 255 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_address_less_than_3_character()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Ba',
            'phone' => '083114514125',
            'sex' => 'M',
        ]);
        
        $response->assertInvalid([
            'address' => 'The address must be at least 3 characters'
        ]);
        $response->assertStatus(302);
    }
    
    public function test_sex_required()
    {
        $response = $this->withoutMiddleware()->patch('/admin/employee/2', [
            'name'=> 'Testing 2',
            'email' => 'testing@mail.com',
            'role_id' => '2',
            'date_of_birth' => '2002-11-11',
            'address' => 'Bandung',
            'phone' => '083114514125',
            'sex' => '',
        ]);
        
        $response->assertInvalid([
            'sex' => 'The sex field is required.'
        ]);
        $response->assertStatus(302);
    }
}