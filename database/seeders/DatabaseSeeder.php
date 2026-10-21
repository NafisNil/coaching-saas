<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Institution;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $roles = ['admin', 'teacher', 'student', 'parent'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

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

        $admin = User::create([
            'first_name' => 'Admin User',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
            'institution_id' => $institution->id,
            'branch_id' => $branch->id,
        ]);

        $admin->assignRole('admin');
    }
}
