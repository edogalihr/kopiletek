<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EmployeeDeleteTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_delete_employee_success()
    {
        $response = $this->withoutMiddleware()->delete('/admin/employee/2');
        
        $response->assertValid(['Employee Deleted Successfully']);
        $response->assertStatus(302);
    }
}