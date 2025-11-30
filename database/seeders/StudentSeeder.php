<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example students
        $students = [
            [
                'student_number' => '19288374643',
                'first_name' => 'Juan',
                'middle_name' => 'Dela Cruz',
                'last_name' => 'Reyes',
                'current_campus' => 'Apalit',
                'current_course' => 'BSIT',
                'current_year_level' => '4th',
                'current_section' => 'A',
                'email' => 'juan.reyes@example.com',
                'password' => Hash::make('portalpassword1'),
            ],
            [
                'student_number' => '19876543210',
                'first_name' => 'Maria',
                'middle_name' => 'Santos',
                'last_name' => 'Lopez',
                'current_campus' => 'San Fernando',
                'current_course' => 'BSBA',
                'current_year_level' => '3rd',
                'current_section' => 'B',
                'email' => 'maria.lopez@example.com',
                'password' => Hash::make('portalpassword2'),
            ],
            [
                'student_number' => '2024511345',
                'first_name' => 'John Benedict',
                'middle_name' => 'Sunga',
                'last_name' => 'Calara',
                'current_campus' => 'Sto. Tomas',
                'current_course' => 'BSIT',
                'current_year_level' => '3rd',
                'current_section' => 'B',
                'email' => 'johnbenedict@gmail.com',
                'password' => Hash::make('benedict123'),
            ],
            [
                'student_number' => '2023445345',
                'first_name' => 'Charizza',
                'middle_name' => 'Ramos',
                'last_name' => 'Flores',
                'current_campus' => 'San Fernando',
                'current_course' => 'BSBA',
                'current_year_level' => '3rd',
                'current_section' => 'B',
                'email' => 'chacharizaaflores@outlook.com',
                'password' => Hash::make('chachaflores24'),
            ],
        ];

        foreach ($students as $student) {
            Student::updateOrCreate([
                'student_number' => $student['student_number']
            ], $student);
        }
    }
}
