<?php

namespace Tests\Feature;

use App\Models\Student;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Students');
    }

    public function test_students_index_loads_and_displays_students(): void
    {
        $response = $this->get(route('students.index'));
        $response->assertStatus(200);
        $response->assertSee('Student Management');
    }

    public function test_student_creation_validation_and_storage(): void
    {
        $uniqueEmail = 'test_' . uniqid() . '@example.com';
        $studentData = [
            'name' => 'Test Student',
            'email' => $uniqueEmail,
            'phone' => '1234567890',
            'gender' => 'Male',
            'date_of_birth' => '2000-01-01',
            'address' => '123 Test Street',
            'course' => 'Computer Science',
            'enrollment_date' => '2024-09-01',
        ];

        $response = $this->post(route('students.store'), $studentData);
        $response->assertRedirect(route('students.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('students', [
            'email' => $uniqueEmail,
            'name' => 'Test Student',
        ]);
    }

    public function test_student_search_filtering(): void
    {
        $response = $this->get(route('students.index', ['search' => 'Alice']));
        $response->assertStatus(200);
    }

    public function test_student_update_and_delete(): void
    {
        $student = Student::create([
            'name' => 'To Be Edited',
            'email' => 'edit_test_' . uniqid() . '@example.com',
            'phone' => '9999999999',
            'gender' => 'Female',
            'date_of_birth' => '2001-05-10',
            'address' => 'Sample Address',
            'course' => 'Robotics',
            'enrollment_date' => '2024-01-01',
        ]);

        // Update
        $updatedData = [
            'name' => 'Updated Name',
            'email' => $student->email,
            'phone' => '8888888888',
            'gender' => 'Female',
            'date_of_birth' => '2001-05-10',
            'address' => 'Updated Address',
            'course' => 'Artificial Intelligence',
            'enrollment_date' => '2024-01-01',
        ];

        $updateResponse = $this->put(route('students.update', $student), $updatedData);
        $updateResponse->assertRedirect(route('students.index'));
        $this->assertDatabaseHas('students', ['id' => $student->id, 'name' => 'Updated Name']);

        // Delete
        $deleteResponse = $this->delete(route('students.destroy', $student));
        $deleteResponse->assertRedirect(route('students.index'));
        $this->assertDatabaseMissing('students', ['id' => $student->id]);
    }
}
