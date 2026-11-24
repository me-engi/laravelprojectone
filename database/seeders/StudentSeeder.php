<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo sample students
        Student::create([
            'name' => 'Alice Johnson',
            'email' => 'alice.johnson@example.com',
            'phone' => '+1 (555) 012-3456',
            'gender' => 'Female',
            'date_of_birth' => '2002-04-15',
            'address' => '123 University Ave, Boston, MA',
            'course' => 'Computer Science',
            'enrollment_date' => '2023-09-01',
        ]);

        Student::create([
            'name' => 'Bob Smith',
            'email' => 'bob.smith@example.com',
            'phone' => '+1 (555) 987-6543',
            'gender' => 'Male',
            'date_of_birth' => '2001-11-20',
            'address' => '456 Campus Drive, Austin, TX',
            'course' => 'Information Technology',
            'enrollment_date' => '2023-09-01',
        ]);

        Student::create([
            'name' => 'Carol Williams',
            'email' => 'carol.williams@example.com',
            'phone' => '+1 (555) 456-7890',
            'gender' => 'Female',
            'date_of_birth' => '2003-01-10',
            'address' => '789 College St, Seattle, WA',
            'course' => 'Business Administration',
            'enrollment_date' => '2024-01-15',
        ]);

        Student::create([
            'name' => 'David Brown',
            'email' => 'david.brown@example.com',
            'phone' => '+1 (555) 234-5678',
            'gender' => 'Male',
            'date_of_birth' => '2000-08-25',
            'address' => '101 Pine Blvd, Chicago, IL',
            'course' => 'Data Science',
            'enrollment_date' => '2024-01-15',
        ]);

        Student::create([
            'name' => 'Alex Taylor',
            'email' => 'alex.taylor@example.com',
            'phone' => '+1 (555) 345-6789',
            'gender' => 'Other',
            'date_of_birth' => '2002-06-30',
            'address' => '202 Elm St, Denver, CO',
            'course' => 'Graphic Design',
            'enrollment_date' => '2024-09-01',
        ]);

        // Generate 15 additional random students using the factory
        Student::factory(15)->create();
    }
}
