<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use App\Models\Institution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Seed Roles
        $roles = ['admin', 'teacher', 'student', 'parent'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // 2. Seed Institution & Branch
        $institution = Institution::create([
            'uuid' => (string) Str::uuid(),
            'name' => 'Default Institution',
            'slug' => Str::slug('Default Institution'),
            'default_currency' => 'USD',
            'is_active' => true
        ]);

        $branch = Branch::create([
            'name' => 'Main Branch',
            'phone' => '1234567890',
            'code' => 'MAIN',
            'address' => '123 Main St',
            'institution_id' => $institution->id,
            'is_main' => true
        ]);

        // 3. Seed Admin User
        $admin = User::create([
            'first_name' => 'Admin User',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'admin',
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
        ]);
        $admin->assignRole('admin');

        // 4. Seed Teacher User & Profile
        $teacherUser = User::create([
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
            'first_name' => 'Teacher User',
            'last_name' => 'Teacher',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'teacher',
        ]);
        $teacherUser->assignRole('teacher');

        $teacherUser->teacher()->create([
            'institution_id' => $institution->id, // Pass institution_id explicitly
            'designation' => 'Physics Teacher',
            'employment_type' => 'full_time'
        ]);

        // 5. Seed Student User & Profile
        $studentUser = User::create([
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
            'first_name' => 'Student User',
            'last_name' => 'Student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'student',
        ]);
        $studentUser->assignRole('student');

        $student = $studentUser->student()->create([
            'institution_id' => $institution->id, // Pass institution_id explicitly
            'branch_id' => $branch->id,
            'student_code' => 'STU001',            // Updated to student_code matching migration
            'risk_level' => 'normal'
        ]);

        // 6. Seed Parent User & Profile
        $parentUser = User::create([
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
            'first_name' => 'Parent User',
            'last_name' => 'Parent',
            'email' => 'parent@example.com',
            'password' => Hash::make('password'),
            'user_type' => 'parent',
        ]);
        $parentUser->assignRole('parent');

        $parent = $parentUser->parent()->create([
            'institution_id' => $institution->id, // Pass institution_id explicitly
            'occupation' => 'Engineer'
        ]);

        // 7. Attach Student to Parent
        $parent->students()->attach($student->id, [
            'relationship_type' => 'father',
            'is_primary_contact' => true
        ]);


        $academicYear = \App\Models\AcademicYear::create([
            'institution_id' => $institution->id,
            'name' => '2026 Academic Session',
            'start_date' => '2026-01-01',
            'end_date' => '2026-12-31',
            'is_current' => true,
        ]);

        // 2. Create Course & Subject
        $course = \App\Models\Course::create([
            'institution_id' => $institution->id,
            'name' => 'HSC Science',
            'code' => 'HSC-SCI',
        ]);

        $subject = $course->subjects()->create([
            'institution_id' => $institution->id,
            'name' => 'Physics 1st Paper',
            'code' => 'PHY-101',
        ]);

        // 3. Create Batch & Enroll Student
        $batch = \App\Models\Batch::create([
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
            'academic_year_id' => $academicYear->id,
            'course_id' => $course->id,
            'name' => 'Physics Batch A',
            'max_capacity' => 30,
            'status' => 'active',
        ]);

        $batch->students()->attach($student->id, ['status' => 'active']);

        // 4. Create Schedule
        $batch->schedules()->create([
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
            'subject_id' => $subject->id,
            'teacher_id' => $teacherUser->teacher->id,
            'room_number' => 'Room 101',
            'day_of_week' => 'saturday',
            'start_time' => '18:00:00',
            'end_time' => '19:30:00',
        ]);



        $dates = ['2026-10-20', '2026-10-21', '2026-10-22', '2026-10-23', '2026-10-24'];
        foreach ($dates as $index => $date) {
            \App\Models\Attendance::create([
                'institution_id' => $institution->id,
                'batch_id' => $batch->id,
                'student_id' => $student->id,
                'date' => $date,
                'status' => $index >= 2 ? 'absent' : 'present', // Flag last 3 as absent
                'marked_by' => $teacherUser->id,
                'method' => 'manual',
            ]);
        }

        $riskService = new \App\Services\StudentRiskService();
        $riskService->evaluateStudentRisk($student);
    }
}